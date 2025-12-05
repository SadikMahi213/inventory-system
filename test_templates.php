<?php

require_once 'vendor/autoload.php';

use App\Exports\ProductsTemplateExport;
use App\Exports\PurchaseRecordsTemplateExport;

// Test Products Template Export
try {
    $export = new ProductsTemplateExport();
    echo "Products Template Export:\n";
    echo "Headers: " . implode(', ', $export->headings()) . "\n";
    
    $dataArray = $export->array();
    echo "Data rows: " . count($dataArray) . " rows\n";
    
    // Display first row of data
    if (count($dataArray) > 0) {
        $firstRow = $dataArray[0];
        echo "First row data: " . implode(', ', $firstRow) . "\n";
    }
    
    echo "\n";
} catch (Exception $e) {
    echo "Error with Products Template Export: " . $e->getMessage() . "\n";
}

// Test Purchase Records Template Export
try {
    $export = new PurchaseRecordsTemplateExport();
    echo "Purchase Records Template Export:\n";
    echo "Headers: " . implode(', ', $export->headings()) . "\n";
    
    $dataArray = $export->array();
    echo "Data rows: " . count($dataArray) . " rows\n";
    
    // Display first row of data
    if (count($dataArray) > 0) {
        $firstRow = $dataArray[0];
        echo "First row data: " . implode(', ', $firstRow) . "\n";
    }
    
    echo "\n";
} catch (Exception $e) {
    echo "Error with Purchase Records Template Export: " . $e->getMessage() . "\n";
}

?>