<?php

namespace App\Events;

use App\Models\SalesRecord;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SalesRecordCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $salesRecord;

    /**
     * Create a new event instance.
     *
     * @param SalesRecord $salesRecord
     */
    public function __construct(SalesRecord $salesRecord)
    {
        $this->salesRecord = $salesRecord;
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
