<?php

namespace App\Listeners;

use App\Events\ScheduleCreatedEvent;
use App\Traits\RecordMessage;

class RecordScheduleListener
{
    use RecordMessage;

    /**
     * Handle the event.
     *
     * @param \App\Events\ScheduleCreatedEvent $event
     *
     * @return void
     */
    public function handle(ScheduleCreatedEvent $event): void
    {
        $this->recordMessage(
            json_encode(
                [
                    'data' => $event->data,
                    'path'     => $event->path
                ]
            )
        );
    }
}
