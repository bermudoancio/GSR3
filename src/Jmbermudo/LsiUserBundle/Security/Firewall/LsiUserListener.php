<?php

namespace Jmbermudo\LsiUserBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Jmbermudo\LsiUserBundle\Security\Authentication\Token\LsiUserToken;

class LsiUserListener implements ListenerInterface
{
    protected $securityContext;
    protected $authenticationManager;

    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager)
    {
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
    }

    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $sesion_antigua = $_SESSION;
        
        $session = $request->getSession();
        
        //Convertimos la sesión antigua a una sesión de symfony
        //Se hace así porque no hay otra forma de acceder a la variable
        foreach ($sesion_antigua as $param => $value) {
            $session->set($param, $value);
        }
        
        $unauthenticatedToken = new LsiUserToken($session);
        
        $unauthenticatedToken->setUser($sesion_antigua['username']);

        try{
            $authenticatedToken = $this
                ->authenticationManager
                ->authenticate($unauthenticatedToken);

            $this->securityContext->setToken($authenticatedToken);
        }
        catch (AuthenticationException $failed) {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $event->setResponse($response);
        }
    }
}