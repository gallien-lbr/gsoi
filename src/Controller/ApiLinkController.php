<?php

namespace App\Controller;

use App\Service\LinkHelpers;
use App\Service\LinkProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;


class HomeController
{
    /**
     * @Route("test", methods={"POST"}, name="api_save")
     */
    public function index(Request $request, LinkProvider $linkProvider): Response
    {
        try {
            $bodyContent = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new BadRequestHttpException('Bad content');
        }

        if (!isset($bodyContent['url'])) {
            throw new BadRequestHttpException('Bad request');
        }

        $url = $bodyContent['url'];

        //$res = $linkProvider->get($url);
        $a = LinkHelpers::isValid($url);
        $b = LinkHelpers::extractType($url);
        var_dump($b);
        var_dump($a);
        //var_dump($res);
        return new Response('debug');
    }
}