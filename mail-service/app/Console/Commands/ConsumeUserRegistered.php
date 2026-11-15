<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

#[Signature('rabbitmq:consume-users')]
#[Description('Consume UserRegistered events from RabbitMQ')]

class ConsumeUserRegistered extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(
            config('services.rabbitmq.host'),
            config('services.rabbitmq.port'),
            config('services.rabbitmq.user'),
            config('services.rabbitmq.password'),
            config('services.rabbitmq.vhost')
        );

        $channel = $connection->channel();

        $channel->exchange_declare(
            'shopwise.events',
            'topic',
            false,
            true,
            false
        );

        $channel->queue_declare(
            'email.user-registered',
            false,
            true,
            false,
            false
        );

        $channel->queue_bind(
            'email.user-registered',
            'shopwise.events',
            'user.registered'
        );

        // One unacknowledged message per consumer.
        $channel->basic_qos(null, 1, null);

        $callback = function (AMQPMessage $message) use ($channel) {
            try {
                $data = json_decode(
                    $message->getBody(),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );

                // Mail::raw(
                //     "Hello {$data['name']}, welcome to ShopWise!",
                //     function ($mail) use ($data) {
                //         $mail->to($data['email'])
                //             ->subject('Welcome to ShopWise');
                //     }
                // );

                // Acknowledge only after successful processing.
                $channel->basic_ack(
                    $message->getDeliveryTag()
                );

                $this->info(
                    'Welcome email sent to '. $data['email']
                );
            } catch (\Throwable $e) {
                report($e);

                // Requeue the message for another attempt.
                $channel->basic_nack(
                    $message->getDeliveryTag(),
                    false,
                    true
                );

                $this->error('Processing failed: ' . $e->getMessage());
            }
        };

        $channel->basic_consume(
            'email.user-registered',
            '',
            false,
            false,
            false,
            false,
            $callback
        );

        $this->info('Waiting for UserRegistered events...');

        try {
            while ($channel->is_consuming()) {
                $channel->wait();
            }
        } finally {
            $channel->close();
            $connection->close();
        }

        return self::SUCCESS;
    }
}
