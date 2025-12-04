<?php

namespace App\Events;

use App\Models\PurchaseRecord;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PurchaseRecordCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $purchaseRecord;

    /**
     * Create a new event instance.
     *
     * @param PurchaseRecord $purchaseRecord
     */
    public function __construct(PurchaseRecord $purchaseRecord)
    {
        $this->purchaseRecord = $purchaseRecord;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
