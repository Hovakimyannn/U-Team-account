<?php

namespace App\Traits;

use Uc\KafkaProducer\Events\ProduceMessageEvent;
use Uc\KafkaProducer\Message;


trait RecordMessage
{
    public function recordMessage(string $message) : void
    {
        $app = app();
        /** @var \Illuminate\Events\Dispatcher $dispatcher */
        $dispatcher = $app['events'];

        $dispatcher->dispatch(
            new ProduceMessageEvent(new Message(
                env('KAFKA_CONSUME_TOPIC'),
                $message,
                '',
                [],
                1
            ))
        );
    }
}
