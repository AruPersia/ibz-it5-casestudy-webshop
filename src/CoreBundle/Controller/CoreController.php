<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\LoginFormType;
use CoreBundle\Message\Message;
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

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->get('doctrine.orm.entity_manager');
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    protected function getLoginForm()
    {
        return $this->createForm(LoginFormType::class);
    }

}