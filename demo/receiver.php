<?php

require_once "../vendor/autoload.php";

$queue = new \ROCMN\ROCMailer\ROCQueue(new \PhpAmqpLib\Connection\AMQPStreamConnection(
    'localhost',
    5672,
    'guest',
    'guest'
));

$transport = Swift_SmtpTransport::newInstance('smtp.example.org', 25)
    ->setUsername('your username')
    ->setPassword('your password')
;

$mailer = new \ROCMN\ROCMailer\ROCMailer(new Swift_Mailer($transport));

$queue->addConsumer(array($mailer, 'handleAMQPRequest'));
$queue->listen();