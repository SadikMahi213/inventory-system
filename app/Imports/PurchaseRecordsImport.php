<?php

namespace App\Imports;

use App\Models\PurchaseRecord;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Schema;
use Throwable;
use Log;

class PurchaseRecordsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnError, SkipsOnFailure
{
    /**
     * Process the collection of rows from the Excel/CSV file
     *
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Skip completely empty rows
            if ($this->isEmptyRow($row)) {
                continue;
            }

            try {
                // Log the row being processed for debugging
                Log::info("Processing row " . ($index + 1) . ": " . json_encode($row));
                
                // Resolve supplier - can be NULL if not provided
                $supplierId = null;
                if (!empty($row['supplier']) || !empty($row['supplier_id'])) {
                    $supplierName = $row['supplier'] ?? null;
                    $supplierIdFromRow = $row['supplier_id'] ?? null;
                    
                    if ($supplierIdFromRow && is_numeric($supplierIdFromRow)) {
                        // Use supplier ID if provided and valid
                        $supplierId = $supplierIdFromRow;
                    } elseif ($supplierName) {
                        // Create or find supplier by name
                        $supplier = Supplier::firstOrCreate(
                            ['name' => $supplierName],
                            [
                                'email' => null,
                                'phone' => null,
                                'address' => null,
                            ]
                        );
                        $supplierId = $supplier->id;
                    }
                }

                // Resolve product - can be NULL if not provided
                $productId = null;
                $productName = null;
                if (!empty($row['product_id']) || !empty($row['product_name'])) {
                    $productIdFromRow = $row['product_id'] ?? null;
                    $productNameFromRow = $row['product_name'] ?? null;
                    
                    if ($productIdFromRow && is_numeric($productIdFromRow)) {
                        // Use product ID if provided and valid
                        $product = Product::find($productIdFromRow);
                        if ($product) {
                            $productId = $product->id;
                            $productName = $product->product_name;
                        } else {
                            Log::warning("Product ID {$productIdFromRow} not found in database");
                        }
                    } elseif ($productNameFromRow) {
                        // Find product by name
                        $product = Product::where('product_name', $productNameFromRow)->first();
                        if ($product) {
                            $productId = $product->id;
                            $productName = $product->product_name;
                        } else {
                            Log::warning("Product with name '{$productNameFromRow}' not found in database");
                        }
                    }
                }

                // Handle payment status - ensure it's a valid value or NULL
                $paymentStatus = null;
                if (!empty($row['payment_status'])) {
                    $status = strtolower(trim($row['payment_status']));
                    if (in_array($status, ['paid', 'due', 'partial'])) {
                        $paymentStatus = $status;
                    } else {
                        Log::warning("Invalid payment status: {$row['payment_status']}");
                    }
                }

                // Calculate total price if missing
                $quantity = !empty($row['quantity_purchased']) ? $row['quantity_purchased'] : (!empty($row['quantity']) ? $row['quantity'] : 0);
                $unitPrice = !empty($row['unit_price_buy']) ? $row['unit_price_buy'] : (!empty($row['unit_price']) ? $row['unit_price'] : 0);
                $totalPrice = !empty($row['total_purchase_cost']) ? $row['total_purchase_cost'] : (!empty($row['total_price']) ? $row['total_price'] : ($quantity * $unitPrice));

                // Prepare purchase record data with proper NULL handling
                $purchaseData = [
                    'date' => !empty($row['date']) ? $row['date'] : null,
                    'invoice_no' => !empty($row['invoice_no']) ? $row['invoice_no'] : null,
                    'product_id' => $productId,
                    'product_name' => $productName ?? (!empty($row['product_name']) ? $row['product_name'] : null),
                    'model' => !empty($row['model']) ? $row['model'] : null,
                    'size' => !empty($row['size']) ? $row['size'] : null,
                    'color_or_material' => !empty($row['color_or_material']) ? $row['color_or_material'] : null,
                    'quality' => !empty($row['quality']) ? $row['quality'] : null,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                    'supplier_id' => $supplierId,
                    'payment_status' => $paymentStatus,
                ];

                // Log the data being inserted
                Log::info("Inserting purchase record: " . json_encode($purchaseData));
                
                // Create purchase record
                $record = PurchaseRecord::create($purchaseData);
                Log::info("Successfully inserted purchase record with ID: " . $record->id);
                
            } catch (Throwable $e) {
                Log::error("Error processing row " . ($index + 1) . ": " . $e->getMessage());
                Log::error("Row data: " . json_encode($row));
                // Continue processing other rows
                continue;
            }
        }
    }

    /**
     * Validation rules for the import
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            // Only validate date if provided
            'date' => 'nullable|date',
            // Only validate numeric fields if provided
            'product_id' => 'nullable|integer|min:1',
            'supplier_id' => 'nullable|integer|min:1',
            'quantity' => 'nullable|numeric|min:0',
            'quantity_purchased' => 'nullable|numeric|min:0',
            'unit_price' => 'nullable|numeric|min:0',
            'unit_price_buy' => 'nullable|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'total_purchase_cost' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Custom validation messages
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'date.date' => 'Date must be a valid date',
            'product_id.integer' => 'Product ID must be a number',
            'product_id.min' => 'Product ID must be at least 1',
            'supplier_id.integer' => 'Supplier ID must be a number',
            'supplier_id.min' => 'Supplier ID must be at least 1',
            'quantity.numeric' => 'Quantity must be a number',
            'quantity.min' => 'Quantity must be at least 0',
            'quantity_purchased.numeric' => 'Quantity purchased must be a number',
            'quantity_purchased.min' => 'Quantity purchased must be at least 0',
            'unit_price.numeric' => 'Unit price must be a number',
            'unit_price.min' => 'Unit price must be at least 0',
            'unit_price_buy.numeric' => 'Unit price (buy) must be a number',
            'unit_price_buy.min' => 'Unit price (buy) must be at least 0',
            'total_price.numeric' => 'Total price must be a number',
            'total_price.min' => 'Total price must be at least 0',
            'total_purchase_cost.numeric' => 'Total purchase cost must be a number',
            'total_purchase_cost.min' => 'Total purchase cost must be at least 0',
        ];
    }

    /**
     * Handle skipped errors
     *
     * @param Throwable $e
     */
    public function onError(Throwable $e)
    {
        Log::error('Purchase record import error: ' . $e->getMessage());
    }

    /**
     * Handle validation failures
     *
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            Log::error('Purchase record import failure on row ' . $failure->row() . ': ' . json_encode($failure->errors()));
        }
    }

    /**
     * Check if a row is completely empty
     *
     * @param array $row
     * @return bool
     */
    private function isEmptyRow($row)
    {
        // Convert Collection to array if needed
        $rowData = $row instanceof Collection ? $row->toArray() : $row;
        
        // Filter out empty values
        $nonEmptyValues = array_filter($rowData, function ($value) {
            return !is_null($value) && $value !== '' && $value !== ' ';
        });
        
        // Return true if no non-empty values found
        return empty($nonEmptyValues);
    }
}