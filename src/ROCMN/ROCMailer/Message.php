<?php
namespace ROCMN\ROCMailer;

use Swift_Message;

class Message extends Swift_Message
{
    public function jsonEncodeMessage()
    {
        return json_encode([
            'subject' => $this->getSubject(),
            'body' => $this->getBody(),
            'contentType' => $this->getContentType(),
            'charset' => $this->getCharset()
        ]);
    }

    public function jsonDecodeMessage($jsonData)
    {
        $rawData = json_decode($jsonData);

        $this->setSubject($rawData['subject']);
        $this->setBody($rawData['body']);
        $this->setContentType($rawData['contentType']);
        $this->setCharset($rawData['charset']);
    }
}