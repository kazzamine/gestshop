<?php
namespace App\security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDenied implements AccessDeniedHandlerInterface{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }
    public function handle(Request $request, AccessDeniedException $accessDeniedException): Response
    {
        return new RedirectResponse($this->urlGenerator->generate('error403'));
    }
}