<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$db = app('db');
try {
    $result = $db->select("SELECT COUNT(*) as count FROM stocks");
    echo "Stocks table exists. Count: " . $result[0]->count . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}