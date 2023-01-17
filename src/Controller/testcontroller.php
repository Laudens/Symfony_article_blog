<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class testcontroller
{
    public Request $request;

    public function index()
    {
        var_dump("ca fonctionne");
        die();
    }
    /**
     * @Route("/test/{age<\d+>?0}", name="test")
     */
    public function test($age, LoggerInterface $logger)
    {
        $logger->error("sa vient déjà");
        return new Response("vous avez $age ans !");
    }
}
