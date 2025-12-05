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

// Test the query
try {
    $featuredProducts = \App\Models\Product::where('is_featured', true)->limit(6)->get();
    echo "Success: Query executed without errors. Found " . $featuredProducts->count() . " featured products.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}