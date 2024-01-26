<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController{

    #[Route('/error403','error403')]
    public function err403():Response{

        return $this->render('bundles/TwigBundle/Exceptions/error403.html.twig',[]);
    }
    #[Route('/error404','error404')]
    public function err404():Response{

        return $this->render('bundles/TwigBundle/Exceptions/error404.html.twig',[]);
    }
}