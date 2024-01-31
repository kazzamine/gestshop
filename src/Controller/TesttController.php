<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TesttController extends AbstractController
{
    #[Route('/api/testt', name: 'app_testt')]
    public function index(): Response
    {
        return $this->render('testt/index.html.twig', [
            'controller_name' => 'TesttController',
        ]);
    }
}
