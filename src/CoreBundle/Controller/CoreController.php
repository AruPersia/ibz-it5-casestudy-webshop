<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\LoginFormType;
use CoreBundle\Message\Message;
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

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->get('doctrine.orm.entity_manager');
    }

    /**
     * @return \CoreBundle\Service\Security\SecurityService
     */
    protected function getSecurityService()
    {
        return $this->get('core.service.security');
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    protected function getLoginForm()
    {
        return $this->createForm(LoginFormType::class);
    }

}