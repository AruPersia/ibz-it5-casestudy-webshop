<?php

namespace Core\Controller;


use Core\Message\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CoreController extends Controller
{

    private $messages = array();

    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $parameters['messages'] = $this->messages;
        return parent::render($view, $parameters, $response);
    }

    protected function addMessage(Message $message)
    {
        $this->messages[] = $message;
    }

}