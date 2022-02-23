<?php

namespace App\Controller;

use App\Service\LinkProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(LinkProvider $linkProvider): Response
    {
        $url = 'https://www.youtube.com/watch?v=PP1xn5wHtxE';
        $linkProvider->get($url);
        return new Response('debug');
    }
}