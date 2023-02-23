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
        public int $courseId,
        public int $groupId,
        public string $path,
    ) {
    }
}
