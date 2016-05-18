<?php

namespace TyrSynchroBundle\Service;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class TyrEventConsumer implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        dump($msg->getBody());
    }
}
