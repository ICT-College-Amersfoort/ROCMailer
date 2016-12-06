<?php
namespace ROCMN\ROCMailer;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class ROCQueue
 * @package ROCMN\ROCMailer
 * @author Dennis Snijder <Dennis@Snijder.io>
 */
class ROCQueue
{
    /**
     * @var AMQPStreamConnection
     */
    private $streamConnection;

    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * ROCQueue constructor.
     * @param AMQPStreamConnection $streamConnection
     */
    public function __construct(AMQPStreamConnection $streamConnection)
    {
        $this->streamConnection = $streamConnection;
        $this->createChannel();
        $this->createQueue();
    }

    /**
     * Creates the channel object
     */
    private function createChannel()
    {
        $this->channel = $this->streamConnection->channel();
    }

    /**
     * Creates a queue used for consuming incomming messages
     */
    public function createQueue()
    {
        $this->channel->queue_declare('mail', false, false, false, false);
    }

    /**
     * adds a basic consumer, needs a callback
     * @param $callback
     */
    public function addConsumer($callback)
    {
        $this->channel->basic_consume('mail', '', false, true, false, false, $callback);
    }


    public function listen()
    {
        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
    
    /**
     * @param Message $message
     */
    public function addNewMessage(Message $message)
    {
        $queueMessage = new AMQPMessage($message->jsonEncodeMessage());
        $this->channel->basic_publish($queueMessage, '', 'mail');
    }

    /**
     * closes the channel and the stream connection.
     */
    public function close()
    {
        $this->channel->close();
        $this->streamConnection->close();
    }
    
}