<?php

namespace App\Exports;

use App\Models\SalesRecord;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesRecordsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SalesRecord::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Invoice No',
            'Customer ID',
            'Product ID',
            'Product Name',
            'Price',
            'Quantity',
            'Total Amount',
            'Payment Status',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * @param mixed $salesRecord
     * @return array
     */
    public function map($salesRecord): array
    {
        return [
            $salesRecord->invoice_no,
            $salesRecord->customer_id,
            $salesRecord->product_id,
            $salesRecord->product_name,
            $salesRecord->price,
            $salesRecord->quantity,
            $salesRecord->total_amount,
            $salesRecord->payment_status,
            $salesRecord->created_at,
            $salesRecord->updated_at,
        ];
    }
}