<?php

require_once "../vendor/autoload.php";

$queue = new \ROCMN\ROCMailer\ROCQueue(new \PhpAmqpLib\Connection\AMQPStreamConnection(
    'localhost',
    5672,
    'guest',
    'guest'
));

//add a alot of messages
for($i = 0; $i < 10; $i++) {
    $queue->addNewMessage(new \ROCMN\ROCMailer\Message("demo", "demo"));
}
$queue->close();