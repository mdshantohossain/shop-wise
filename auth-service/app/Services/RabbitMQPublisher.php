<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQPublisher
{
    private ?AMQPStreamConnection $connection = null;

    private function getConnection(): AMQPStreamConnection
    {
        if($this->connection === null || !$this->connection->isConnected()) {
            $this->connection = new AMQPStreamConnection(
                config('services.rabbitmq.host'),
                config('services.rabbitmq.port'),
                config('services.rabbitmq.user'),
                config('services.rabbitmq.password'),
                config('services.rabbitmq.vhost')
            );
        }

        return $this->connection;
    }
    /**
     * @throws \JsonException
     */
    public function publish(
        string $routeKey,
        array $payload
    ): void {

        try {
            $connection = $this->getConnection();
            $channel = $connection->channel();

            $channel->exchange_declare(
                'shopwise.events',
                'topic',
                durable: true,
                auto_delete: false
            );

            $message = new AMQPMessage(
                json_encode($payload, JSON_THROW_ON_ERROR),
                [
                    'content_type' => 'application/json',
                    'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
                ]
            );

            $channel->basic_publish(
                $message,
                'shopwise.events',
                $routeKey);

            $channel->close();

        } catch (\JsonException $e) {
            logger($e);
            throw $e;
        }
    }

    public function __destruct()
    {
        if($this->connection && $this->connection->isConnected()) {
            $this->connection->close();
        }
    }
}
