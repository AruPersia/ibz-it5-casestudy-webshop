<?php

namespace CoreBundle\Controller;

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
     * @return \CoreBundle\Service\Security\UserAuthenticationService|object
     */
    protected function getAuthenticationService()
    {
        return $this->get('core.service.authentication');
    }

    /**
     * @return \CoreBundle\Repository\UserAuthenticationRepository
     */
    protected function getUserAuthenticationRepository()
    {
        return $this->getEntityManager()->getRepository('BackendBundle:AdministratorEntity');
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->get('doctrine.orm.entity_manager');
    }

}