<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip empty rows
            if ($this->isEmptyRow($row)) {
                continue;
            }

            // Get or create category
            $category = Category::firstOrCreate(
                ['name' => $row['category']],
                ['description' => 'Auto-created during product import']
            );

            // Check if product with this code already exists
            $product = Product::where('product_code', $row['product_code'])->first();

            // Prepare product data
            $productData = [
                'product_name' => $row['product_name'],
                'size' => $row['size'] ?? null,
                'brand' => $row['brand'] ?? null,
                'grade' => $row['grade'] ?? null,
                'material' => $row['material'] ?? null,
                'color' => $row['color'] ?? null,
                'model_no' => $row['model_no'] ?? null,
                'product_code' => $row['product_code'],
                'unit_qty' => $row['unit_qty'] ?? 0,
                'unit' => $row['unit'] ?? 'piece',
                'unit_rate' => $row['unit_rate'] ?? 0,
                'total_buy' => $row['total_buy'] ?? ($row['unit_qty'] ?? 0) * ($row['unit_rate'] ?? 0),
                'category_id' => $category->id,
                'quantity' => $row['quantity'] ?? 0,
                'approximate_rate' => $row['approximate_rate'] ?? 0,
                'authentication_rate' => $row['authentication_rate'] ?? 0,
                'sell_rate' => $row['sell_rate'] ?? 0,
            ];

            if ($product) {
                // Update existing product
                $product->update($productData);
            } else {
                // Create new product
                Product::create($productData);
            }
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_name' => 'required|string|max:255',
            'product_code' => 'required|string|unique:products,product_code',
            'unit_qty' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'unit_rate' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'product_name.required' => 'Product name is required',
            'product_code.required' => 'Product code is required',
            'product_code.unique' => 'Product code must be unique',
            'unit_qty.required' => 'Unit quantity is required',
            'unit.required' => 'Unit is required',
            'unit_rate.required' => 'Unit rate is required',
            'category.required' => 'Category is required',
        ];
    }

    /**
     * Check if a row is empty
     */
    private function isEmptyRow($row)
    {
        // Convert Collection to array if needed
        $rowData = $row instanceof Collection ? $row->toArray() : $row;
        
        return empty(array_filter($rowData, function ($value) {
            return !is_null($value) && $value !== '';
        }));
    }
}