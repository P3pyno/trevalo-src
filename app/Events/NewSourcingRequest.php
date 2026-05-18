<?php
namespace App\Events;

use App\Models\SourcingRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewSourcingRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public SourcingRequest $sourcingRequest) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('admin'),
        ];
    }

    public function broadcastWith(): array
    {
        $this->sourcingRequest->load('user:id,name,email');
        return ['request' => $this->sourcingRequest->toArray()];
    }

    public function broadcastAs(): string
    {
        return 'new.request';
    }
}
