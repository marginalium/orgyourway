<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test_route')]
    public function index(): Response
    {
        return new Response('welcome ' . getenv('APP_ENV'), Response::HTTP_OK);
    }
}
