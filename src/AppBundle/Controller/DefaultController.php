<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends WebShopController
{
    /**
     * @A\Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

}
