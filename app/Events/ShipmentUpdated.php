<?php
namespace App\Events;

use App\Models\Shipment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShipmentUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Shipment $shipment) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->shipment->sourcingRequest->user_id),
        ];
    }

    public function broadcastWith(): array
    {
        return ['shipment' => $this->shipment->toArray()];
    }

    public function broadcastAs(): string
    {
        return 'shipment.updated';
    }
}
