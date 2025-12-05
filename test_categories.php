<?php

require_once 'vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

// Set up Laravel components
$container = new Container();
$events = new Dispatcher($container);

$capsule = new Capsule($container);
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'inventory_system',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setEventDispatcher($events);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Test the categories table
try {
    // Check if table exists
    $tableExists = \Illuminate\Support\Facades\Schema::hasTable('categories');
    echo "Categories table exists: " . ($tableExists ? 'Yes' : 'No') . "\n";
    
    if ($tableExists) {
        // Count categories
        $count = \App\Models\Category::count();
        echo "Number of categories: " . $count . "\n";
        
        // List categories
        $categories = \App\Models\Category::all();
        echo "Categories:\n";
        foreach ($categories as $category) {
            echo "- " . $category->name . "\n";
        }
    }
    
    echo "All tests passed!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}