<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;
use Predis\Client;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends AbstractController
{
    #[Route('/loginpage','loginpage')]
    public function loginpage()
    {
        if($this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->render('landing/index.html.twig');

        }
        return $this->render('login/index.html.twig');
    }

    #[Route('/login', name: 'app_login')]
    public function index(Request $request,JWTTokenManagerInterface $jwtManager,Client $redis,SessionInterface $session): Response
    {
        
        $user=$this->getUser();
        
        if(!$user instanceof UserInterface){
            throw new BadCredentialsException('invalid credentials');
        }
        $userToken=$jwtManager->create($user);
        $sessionId = $session->getId();
        $redisKey = 'session:' . $sessionId;
        $redisData = json_encode([
            'jwt' => $userToken,
            'user' => $user,
        ]);

        $redis->set($redisKey, $redisData);
        return $this->json(['jwtToken'=>$userToken,
        'username'=>$user->getUserIdentifier()]);
    }
    
    #[Route('/logout',name:'logout')]
    public function logout(Client $redis,SessionInterface $session)
    {   
        $sessionid=$session->getId();
        $redis->del('session:'.$sessionid);
        return $this->json(['state'=>'logged out']);
    }
}
