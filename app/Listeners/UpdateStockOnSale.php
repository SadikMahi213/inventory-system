<?php

namespace App\Listeners;

use App\Events\SalesRecordCreated;
use App\Services\StockService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStockOnSale
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
    public function handle(SalesRecordCreated $event): void
    {
        $this->stockService->updateStockFromSale($event->salesRecord);
    }
}
