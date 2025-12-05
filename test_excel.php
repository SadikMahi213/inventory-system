<?php

require_once 'vendor/autoload.php';

use Maatwebsite\Excel\Excel;
use App\Exports\ProductsTemplateExport;

// Test if we can instantiate the export class
try {
    $export = new ProductsTemplateExport();
    echo "ProductsTemplateExport class instantiated successfully!\n";
    echo "Headings: " . print_r($export->headings(), true) . "\n";
} catch (Exception $e) {
    echo "Error instantiating ProductsTemplateExport: " . $e->getMessage() . "\n";
}