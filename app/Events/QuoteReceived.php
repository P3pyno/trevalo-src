<?php
namespace App\Events;

use App\Models\Quote;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuoteReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Quote $quote) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->quote->sourcingRequest->user_id),
        ];
    }

    public function broadcastWith(): array
    {
        $this->quote->load(['sourcingRequest:id,title', 'supplier:id,supplier_code']);
        return ['quote' => $this->quote->toArray()];
    }

    public function broadcastAs(): string
    {
        return 'quote.received';
    }
}
