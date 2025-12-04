<?php

namespace App\Listeners;

use App\Events\PurchaseRecordCreated;
use App\Services\StockService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStockOnPurchase
{
    /**
     * Create the event listener.
     */
    public function __construct(protected StockService $stockService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PurchaseRecordCreated $event): void
    {
        $this->stockService->updateStockFromPurchase($event->purchaseRecord);
    }
}
