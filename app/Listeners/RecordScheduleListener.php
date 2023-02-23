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
                    'courseId' => $event->courseId,
                    'groupId'  => $event->groupId,
                    'path'     => $event->path
                ]
            )
        );
    }
}
