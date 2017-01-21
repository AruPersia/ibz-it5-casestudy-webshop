<?php

namespace CoreBundle\Util\Json;

use Symfony\Component\HttpFoundation\Response;

class JsonUtil
{

    public static function renderJson(JsonData $jsonDataSupport = null)
    {
        return self::render(json_encode($jsonDataSupport->getJsonData()));
    }

    /**
     * @param $arrayData
     * @return Response
     */
    private static function render($arrayData)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($arrayData);
        return $response;
    }

}