<?php

namespace App\Exports;

use App\Models\PurchaseRecord;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PurchaseRecordsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PurchaseRecord::with(['product', 'supplier'])->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Date',
            'Product Id',
            'Product Name',
            'Product Model',
            'Size',
            'Color',
            'Grade / Quality',
            'Quantity',
            'Unit',
            'Unit Price',
            'Total Price',
            'Supplier',
            'Payment Status',
        ];
    }

    /**
     * @param PurchaseRecord $purchaseRecord
     * @return array
     */
    public function map($purchaseRecord): array
    {
        return [
            $purchaseRecord->date,
            $purchaseRecord->product_id,
            $purchaseRecord->product_name,
            $purchaseRecord->model,
            $purchaseRecord->size,
            $purchaseRecord->color,
            $purchaseRecord->quality,
            $purchaseRecord->quantity,
            $purchaseRecord->unit,
            $purchaseRecord->unit_price,
            $purchaseRecord->total_price,
            $purchaseRecord->supplier->name ?? '',
            ucfirst($purchaseRecord->payment_status),
        ];
    }
}