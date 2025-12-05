<?php

namespace App\Imports;

use App\Models\PurchaseRecord;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PurchaseRecordsImport implements ToCollection, WithHeadingRow, WithValidation
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

            // Get or create supplier
            $supplier = Supplier::firstOrCreate(
                ['name' => $row['supplier']],
                [
                    'email' => null,
                    'phone' => null,
                    'address' => null,
                ]
            );

            // Get product by ID or name
            $product = null;
            if (!empty($row['product_id'])) {
                $product = Product::find($row['product_id']);
            } elseif (!empty($row['product_name'])) {
                $product = Product::where('product_name', $row['product_name'])->first();
            }

            // Skip if no product found
            if (!$product) {
                continue;
            }

            // Calculate total price if missing
            $totalPrice = $row['total_price'] ?? ($row['quantity'] * $row['unit_price']);

            // Prepare purchase record data
            $purchaseData = [
                'date' => $row['date'],
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'model' => $product->model_no ?? $row['product_model'] ?? null,
                'size' => $product->size ?? $row['size'] ?? null,
                'color' => $product->color ?? $row['color'] ?? null,
                'quality' => $product->grade ?? $row['grade_quality'] ?? null,
                'quantity' => $row['quantity'],
                'unit' => $product->unit ?? $row['unit'] ?? 'piece',
                'unit_price' => $row['unit_price'],
                'total_price' => $totalPrice,
                'supplier_id' => $supplier->id,
                'payment_status' => strtolower($row['payment_status']) === 'paid' ? 'paid' : 
                                  (strtolower($row['payment_status']) === 'partial' ? 'partial' : 'due'),
            ];

            // Create purchase record
            PurchaseRecord::create($purchaseData);
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'date.required' => 'Date is required',
            'quantity.required' => 'Quantity is required',
            'unit_price.required' => 'Unit price is required',
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