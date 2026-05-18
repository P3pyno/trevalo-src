<?php
namespace App\Events;

use App\Models\SourcingRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public SourcingRequest $sourcingRequest) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->sourcingRequest->user_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id'     => $this->sourcingRequest->id,
            'status' => $this->sourcingRequest->status,
            'title'  => $this->sourcingRequest->title,
        ];
    }

    public function broadcastAs(): string
    {
        return 'request.status.updated';
    }
}
