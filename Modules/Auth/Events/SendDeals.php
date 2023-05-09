<?php

namespace Modules\Auth\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendDeals  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $deals;

    public function __construct($deals)
    {
        $this->deals = $deals;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [
            'deals'
        ];
    }


    public function broadcastWith()
    {
        return [
            'Deal' => ' A new Deal from  ' . $this->deals->name,
        ];
    }
}
