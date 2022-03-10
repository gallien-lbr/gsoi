<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    public function index():Response{
        $a  = true;
        return new Response('<html>Test index</html>');
    }
}