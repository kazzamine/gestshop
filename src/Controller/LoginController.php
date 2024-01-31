<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/loginpage','loginpage')]
    public function loginpage()
    {
        return $this->render('login/index.html.twig');
    }

    #[Route('/login', name: 'app_login')]
    public function index(Request $request,JWTTokenManagerInterface $jwtManager): Response
    {
        $user=$this->getUser();
        if(!$user instanceof UserInterface){
            throw new BadCredentialsException('invalid credentials');
        }
        $userToken=$jwtManager->create($user);
        return $this->json(['jwtToken'=>$userToken,
        'username'=>$user->getUserIdentifier()]);
    }
}
