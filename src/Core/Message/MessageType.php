<?php

namespace Core\Message;

class MessageType
{

    const SUCCESS = 'success';
    const INFO = 'info';
    const WARNING = 'warning';
    const DANGER = 'danger';

    private $name;

    private function __construct(String $name)
    {
        $this->name = $name;
    }

    public function getName(): String
    {
        return $this->name;
    }

    /**
     * @return MessageType
     */
    public static function SUCCESS()
    {
        return new MessageType(self::SUCCESS);
    }

    /**
     * @return MessageType
     */
    public static function INFO()
    {
        return new MessageType(self::INFO);
    }

    /**
     * @return MessageType
     */
    public static function WARNING()
    {
        return new MessageType(self::WARNING);
    }

    /**
     * @return MessageType
     */
    public static function DANGER()
    {
        return new MessageType(self::DANGER);
    }
}