<?php

namespace App\Imports;

use App\Models\SalesRecord;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;
use Illuminate\Support\Facades\Log;

class SalesRecordsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsOnError, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Validate required fields
        if (empty($row['invoice_no']) || empty($row['customer_id']) || empty($row['product_id']) || 
            empty($row['product_name']) || empty($row['price']) || empty($row['quantity'])) {
            return null; // Skip invalid rows
        }

        // Calculate total amount
        $totalAmount = $row['price'] * $row['quantity'];

        // Prepare timestamps
        $now = now();
        $createdAt = isset($row['created_at']) ? $row['created_at'] : $now;
        $updatedAt = isset($row['updated_at']) ? $row['updated_at'] : $now;
        
        // Use updateOrCreate to handle both new and existing records
        $record = SalesRecord::updateOrCreate(
            ['invoice_no' => $row['invoice_no']], // Search for existing record by invoice_no
            [
                'customer_id' => $row['customer_id'],
                'product_id' => $row['product_id'],
                'product_name' => $row['product_name'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'total_amount' => $totalAmount,
                'payment_status' => $row['payment_status'] ?? 'pending',
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]
        );

        return $record;
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
     * @param Throwable $e
     */
    public function onError(Throwable $e)
    {
        // Log the error
        Log::error('Sales Record Import Error: ' . $e->getMessage());
    }

    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            // Log each failure
            Log::error('Sales Record Import Failure: ' . json_encode($failure->toArray()));
        }
    }
}