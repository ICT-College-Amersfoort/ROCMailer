<?php
namespace ROCMN\ROCMailer;
use PhpAmqpLib\Message\AMQPMessage;


/**
 * Class ROCMailer
 * @package ROCMN\ROCMailer
 * @author Dennis Snijder <Dennis@Snijder.io>
 */
class ROCMailer 
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * ROCMailer constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail(\Swift_Message $message)
    {
        $this->mailer->send($message);
    }

    public function handleAMQPRequest(AMQPMessage $message)
    {
        $message = new Message();
        $message->jsonDecodeMessage($message->getBody());

        $message->getBody();
    }
    
}