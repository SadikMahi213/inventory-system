<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with('category')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Product Name',
            'Size',
            'Brand',
            'Grade',
            'Material',
            'Color',
            'Model No',
            'Product Code',
            'Unit Qty',
            'Unit',
            'Unit Rate',
            'Total Buy',
            'Category',
            'Quantity',
            'Approximate Rate',
            'Authentication Rate',
            'Sell Rate',
        ];
    }

    /**
     * @param Product $product
     * @return array
     */
    public function map($product): array
    {
        return [
            $product->product_name,
            $product->size,
            $product->brand,
            $product->grade,
            $product->material,
            $product->color,
            $product->model_no,
            $product->product_code,
            $product->unit_qty,
            $product->unit,
            $product->unit_rate,
            $product->total_buy,
            $product->category->name ?? '',
            $product->quantity,
            $product->approximate_rate,
            $product->authentication_rate,
            $product->sell_rate,
        ];
    }
}