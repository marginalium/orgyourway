<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return new Response('This page does not exist.', Response::HTTP_NOT_FOUND);
    }
}