<?php

namespace App\Services;

use App\Models\Product;
use App\Models\PurchaseRecord;
use App\Models\SalesRecord;
use App\Models\Stock;
use App\Models\ProfitLoss;
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use League\Csv\Reader;
use League\Csv\Writer;

class CsvService
{
    /**
     * Export products to CSV
     *
     * @param string $filename
     * @return string
     */
    public function exportProducts($filename = 'products.csv')
    {
        $products = Product::all();
        
        $csv = Writer::createFromPath(storage_path('app/public/' . $filename), 'w+');
        $csv->insertOne(['ID', 'Product Code', 'Name', 'Description', 'Category', 'Unit', 'Selling Price', 'Created At', 'Updated At']);
        
        foreach ($products as $product) {
            $csv->insertOne([
                $product->id,
                $product->product_code,
                $product->name,
                $product->description,
                $product->category,
                $product->unit,
                $product->selling_price,
                $product->created_at,
                $product->updated_at
            ]);
        }
        
        return 'public/' . $filename;
    }
    
    /**
     * Import products from CSV
     *
     * @param UploadedFile $file
     * @return int
     */
    public function importProducts(UploadedFile $file)
    {
        $csv = Reader::createFromPath($file->getPathname(), 'r');
        $csv->setHeaderOffset(0);
        
        $records = $csv->getRecords();
        $importedCount = 0;
        
        foreach ($records as $record) {
            Product::updateOrCreate(
                ['product_code' => $record['Product Code']],
                [
                    'name' => $record['Name'],
                    'description' => $record['Description'] ?? null,
                    'category' => $record['Category'] ?? null,
                    'unit' => $record['Unit'] ?? null,
                    'selling_price' => $record['Selling Price'] ?? 0
                ]
            );
            $importedCount++;
        }
        
        return $importedCount;
    }
    
    /**
     * Export purchase records to CSV
     *
     * @param string $filename
     * @return string
     */
    public function exportPurchaseRecords($filename = 'purchase_records.csv')
    {
        $purchases = PurchaseRecord::with(['product', 'supplier'])->get();
        
        $csv = Writer::createFromPath(storage_path('app/public/' . $filename), 'w+');
        $csv->insertOne(['ID', 'Date', 'Product ID', 'Product Name', 'Supplier ID', 'Supplier Name', 'Quantity', 'Unit Price', 'Total Price', 'Payment Status', 'Created At', 'Updated At']);
        
        foreach ($purchases as $purchase) {
            $csv->insertOne([
                $purchase->id,
                $purchase->date,
                $purchase->product_id,
                $purchase->product->name ?? $purchase->product_name,
                $purchase->supplier_id,
                $purchase->supplier->name ?? $purchase->supplier_name,
                $purchase->quantity,
                $purchase->unit_price,
                $purchase->total_price,
                $purchase->payment_status,
                $purchase->created_at,
                $purchase->updated_at
            ]);
        }
        
        return 'public/' . $filename;
    }
    
    /**
     * Import purchase records from CSV
     *
     * @param UploadedFile $file
     * @return int
     */
    public function importPurchaseRecords(UploadedFile $file)
    {
        $csv = Reader::createFromPath($file->getPathname(), 'r');
        $csv->setHeaderOffset(0);
        
        $records = $csv->getRecords();
        $importedCount = 0;
        
        foreach ($records as $record) {
            PurchaseRecord::create([
                'date' => $record['Date'],
                'product_id' => $record['Product ID'],
                'product_name' => $record['Product Name'],
                'supplier_id' => $record['Supplier ID'] ?? null,
                'supplier_name' => $record['Supplier Name'] ?? null,
                'quantity' => $record['Quantity'],
                'unit_price' => $record['Unit Price'],
                'total_price' => $record['Total Price'],
                'payment_status' => $record['Payment Status']
            ]);
            $importedCount++;
        }
        
        return $importedCount;
    }
    
    /**
     * Export sales records to CSV
     *
     * @param string $filename
     * @return string
     */
    public function exportSalesRecords($filename = 'sales_records.csv')
    {
        $sales = SalesRecord::with(['product', 'customer'])->get();
        
        $csv = Writer::createFromPath(storage_path('app/public/' . $filename), 'w+');
        $csv->insertOne(['ID', 'Invoice No', 'Customer ID', 'Customer Name', 'Product ID', 'Product Name', 'Price', 'Quantity', 'Total Amount', 'Payment Status', 'Created At', 'Updated At']);
        
        foreach ($sales as $sale) {
            $csv->insertOne([
                $sale->id,
                $sale->invoice_no,
                $sale->customer_id,
                $sale->customer->name ?? $sale->customer_name,
                $sale->product_id,
                $sale->product_name,
                $sale->price,
                $sale->quantity,
                $sale->total_amount,
                $sale->payment_status,
                $sale->created_at,
                $sale->updated_at
            ]);
        }
        
        return 'public/' . $filename;
    }
    
    /**
     * Import sales records from CSV
     *
     * @param UploadedFile $file
     * @return int
     */
    public function importSalesRecords(UploadedFile $file)
    {
        $csv = Reader::createFromPath($file->getPathname(), 'r');
        $csv->setHeaderOffset(0);
        
        $records = $csv->getRecords();
        $importedCount = 0;
        
        foreach ($records as $record) {
            SalesRecord::create([
                'invoice_no' => $record['Invoice No'],
                'customer_id' => $record['Customer ID'],
                'customer_name' => $record['Customer Name'],
                'product_id' => $record['Product ID'],
                'product_name' => $record['Product Name'],
                'price' => $record['Price'],
                'quantity' => $record['Quantity'],
                'total_amount' => $record['Total Amount'],
                'payment_status' => $record['Payment Status']
            ]);
            $importedCount++;
        }
        
        return $importedCount;
    }
    
    /**
     * Export stock records to CSV
     *
     * @param string $filename
     * @return string
     */
    public function exportStock($filename = 'stock.csv')
    {
        $stocks = Stock::with('product')->get();
        
        $csv = Writer::createFromPath(storage_path('app/public/' . $filename), 'w+');
        $csv->insertOne(['ID', 'Product ID', 'Product Name', 'Purchase Quantity', 'Sales Quantity', 'Current Stock', 'Average Cost', 'Created At', 'Updated At']);
        
        foreach ($stocks as $stock) {
            $csv->insertOne([
                $stock->id,
                $stock->product_id,
                $stock->product->name ?? 'N/A',
                $stock->purchase_quantity,
                $stock->sales_quantity,
                $stock->current_stock,
                $stock->average_cost,
                $stock->created_at,
                $stock->updated_at
            ]);
        }
        
        return 'public/' . $filename;
    }
    
    /**
     * Export profit and loss records to CSV
     *
     * @param string $filename
     * @return string
     */
    public function exportProfitLoss($filename = 'profit_loss.csv')
    {
        $profitLossRecords = ProfitLoss::with('product')->get();
        
        $csv = Writer::createFromPath(storage_path('app/public/' . $filename), 'w+');
        $csv->insertOne(['ID', 'Product ID', 'Product Name', 'Revenue', 'COGS', 'Staff Cost', 'Shop Cost', 'Transport Cost', 'Other Expense', 'Total Expenses', 'Net Profit', 'Report Date', 'Created At', 'Updated At']);
        
        foreach ($profitLossRecords as $record) {
            $csv->insertOne([
                $record->id,
                $record->product_id,
                $record->product->name ?? 'Overall',
                $record->revenue,
                $record->cogs,
                $record->staff_cost,
                $record->shop_cost,
                $record->transport_cost,
                $record->other_expense,
                $record->total_expenses,
                $record->net_profit,
                $record->report_date,
                $record->created_at,
                $record->updated_at
            ]);
        }
        
        return 'public/' . $filename;
    }
    
    /**
     * Export suppliers to CSV
     *
     * @param string $filename
     * @return string
     */
    public function exportSuppliers($filename = 'suppliers.csv')
    {
        $suppliers = Supplier::all();
        
        $csv = Writer::createFromPath(storage_path('app/public/' . $filename), 'w+');
        $csv->insertOne(['ID', 'Name', 'Contact Person', 'Phone', 'Email', 'Address', 'Company Name', 'Created At', 'Updated At']);
        
        foreach ($suppliers as $supplier) {
            $csv->insertOne([
                $supplier->id,
                $supplier->name,
                $supplier->contact_person,
                $supplier->phone,
                $supplier->email,
                $supplier->address,
                $supplier->company_name,
                $supplier->created_at,
                $supplier->updated_at
            ]);
        }
        
        return 'public/' . $filename;
    }
    
    /**
     * Export customers to CSV
     *
     * @param string $filename
     * @return string
     */
    public function exportCustomers($filename = 'customers.csv')
    {
        $customers = Customer::all();
        
        $csv = Writer::createFromPath(storage_path('app/public/' . $filename), 'w+');
        $csv->insertOne(['ID', 'Name', 'Phone', 'Email', 'Address', 'Created At', 'Updated At']);
        
        foreach ($customers as $customer) {
            $csv->insertOne([
                $customer->id,
                $customer->name,
                $customer->phone,
                $customer->email,
                $customer->address,
                $customer->created_at,
                $customer->updated_at
            ]);
        }
        
        return 'public/' . $filename;
    }
}