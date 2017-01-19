<?php

namespace CoreBundle\Service\Security;

use Symfony\Component\HttpFoundation\Request;

interface SecurityControllerSupport
{

    /**
     * Rendering login form.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction();

    /**
     * Verify login information and crate UsernamePasswordToken.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpFoundation\RedirectResponse
     * @see \CoreBundle\Service\Security\SecurityService
     * @see \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken
     */
    public function loginVerifyAction(Request $request);

    /**
     * Logout and clear UsernamePasswordToken respectively.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @see \CoreBundle\Service\Security\SecurityService
     */
    public function logoutAction();

}