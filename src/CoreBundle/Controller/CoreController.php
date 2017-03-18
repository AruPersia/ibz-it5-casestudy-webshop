<?php

namespace CoreBundle\Controller;

use CoreBundle\Message\Message;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoreController extends ServiceController
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

    protected function entityManager(): EntityManager
    {
        return $this->get('doctrine.orm.entity_manager');
    }

    protected function getRequest(): Request
    {
        return ($this->get('request_stack'))->getCurrentRequest();
    }

}