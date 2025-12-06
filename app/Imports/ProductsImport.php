<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\Schema;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, WithUpserts, WithBatchInserts, SkipsOnError, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Handle category assignment according to specification
        $categoryId = null;
        
        // Check if category_id is provided directly
        if (!empty($row['category_id']) && is_numeric($row['category_id'])) {
            $categoryId = $row['category_id'];
        }
        // Check if category name is provided
        elseif (!empty($row['category']) || !empty($row['category_name'])) {
            $categoryName = $row['category'] ?? $row['category_name'];
            if (!empty($categoryName)) {
                // Create or find category
                if (Schema::hasTable('categories')) {
                    $category = Category::firstOrCreate(
                        ['name' => $categoryName],
                        ['description' => 'Auto-created during product import']
                    );
                    $categoryId = $category->id;
                }
            }
        }
        // If neither category_id nor category name is provided, categoryId remains null

        // Check if product with this code already exists
        $existingProduct = !empty($row['product_code']) ? Product::where('product_code', $row['product_code'])->first() : null;

        // Prepare product data with all columns, handling missing/empty values
        $productData = [
            'product_code' => $row['product_code'] ?? null,
            'unit_qty' => !empty($row['unit_qty']) ? $row['unit_qty'] : 0,
            'unit_rate' => !empty($row['unit_rate']) ? $row['unit_rate'] : 0,
            'total_buy' => !empty($row['total_buy']) ? $row['total_buy'] : 0,
            'product_name' => $row['product_name'] ?? $row['name'] ?? null,
            'model' => $row['model'] ?? null,
            'size' => $row['size'] ?? null,
            'brand' => $row['brand'] ?? null,
            'grade' => $row['grade'] ?? null,
            'material' => $row['material'] ?? null,
            'color' => $row['color'] ?? null,
            'model_no' => $row['model_no'] ?? null,
            'quality' => $row['quality'] ?? null,
            'unit' => $row['unit'] ?? null,
            'unit_price' => !empty($row['unit_price']) ? $row['unit_price'] : 0,
            'selling_price' => !empty($row['selling_price']) ? $row['selling_price'] : 0,
            'description' => $row['description'] ?? null,
            'is_featured' => !empty($row['is_featured']) ? (bool)$row['is_featured'] : false,
            'category_id' => $categoryId,
            'quantity' => !empty($row['quantity']) ? $row['quantity'] : 0,
            'approximate_rate' => !empty($row['approximate_rate']) ? $row['approximate_rate'] : 0,
            'authentication_rate' => !empty($row['authentication_rate']) ? $row['authentication_rate'] : 0,
            'sell_rate' => !empty($row['sell_rate']) ? $row['sell_rate'] : 0,
        ];

        if ($existingProduct) {
            // Update existing product
            $existingProduct->update($productData);
            return null; // Return null to skip inserting
        } else {
            // Create new product
            return new Product($productData);
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            // Removed the unique rule to allow imports without validation errors
            // The upsert functionality will handle duplicates
            'product_name' => 'nullable|string|max:255',
            'unit_rate' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'unit_rate.numeric' => 'Unit rate must be a number',
            'quantity.numeric' => 'Quantity must be a number',
        ];
    }

    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'product_code';
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * Handle skipped errors
     *
     * @param Throwable $e
     */
    public function onError(Throwable $e)
    {
        // Log the error but continue processing
        \Illuminate\Support\Facades\Log::error('Product import error: ' . $e->getMessage());
    }

    /**
     * Handle validation failures
     *
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        // Log the failures but continue processing
        foreach ($failures as $failure) {
            \Illuminate\Support\Facades\Log::error('Product import failure on row ' . $failure->row() . ': ' . json_encode($failure->errors()));
        }
    }
}