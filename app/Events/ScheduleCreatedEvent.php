<?php

namespace App\Events;

class ScheduleCreatedEvent
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        public array $data,
        public string $path,
    ) {
    }
}
