<?php

namespace CoreBundle\Message;

class Message
{

    private $title;
    private $text;
    private $messageType;

    private function __construct(String $title, String $text, MessageType $messageType)
    {
        $this->title = $title;
        $this->text = $text;
        $this->messageType = $messageType;
    }

    public static function success(String $title, String $text)
    {
        return new Message($title, $text, MessageType::SUCCESS());
    }

    public static function info(String $title, String $text)
    {
        return new Message($title, $text, MessageType::INFO());
    }

    public static function warning(String $title, String $text)
    {
        return new Message($title, $text, MessageType::WARNING());
    }

    public static function danger(String $title, String $text)
    {
        return new Message($title, $text, MessageType::DANGER());
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getType()
    {
        return $this->messageType->getName();
    }

}