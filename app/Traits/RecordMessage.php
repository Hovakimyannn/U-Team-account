<?php

namespace App\Traits;

use Uc\KafkaProducer;

trait RecordMessage
{
    public function recordMessage(string $path) : void
    {
        $app = app();
        /** @var \Illuminate\Events\Dispatcher $dispatcher */
        $dispatcher = $app['events'];

        $dispatcher->dispatch(
            new KafkaProducer\Events\ProduceMessageEvent(new KafkaProducer\Message(
                env('KAFKA_CONSUME_TOPIC'),
                $path,
                '',
                [],
                1
            ))
        );
    }
}