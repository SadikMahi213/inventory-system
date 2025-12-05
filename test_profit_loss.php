<?php

require_once 'vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\ProfitLoss;

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

// Test the ProfitLoss model
try {
    // Create a test record
    $profitLoss = new ProfitLoss();
    $profitLoss->date = '2025-12-05';
    $profitLoss->total_sales = 1000.00;
    $profitLoss->total_purchase_cost = 600.00;
    $profitLoss->operating_cost = 100.00;
    $profitLoss->net_profit = 300.00;
    $profitLoss->save();
    
    echo "ProfitLoss record created successfully!\n";
    
    // Test querying
    $totalProfit = ProfitLoss::sum('net_profit');
    echo "Total profit: $" . $totalProfit . "\n";
    
    echo "All tests passed!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}