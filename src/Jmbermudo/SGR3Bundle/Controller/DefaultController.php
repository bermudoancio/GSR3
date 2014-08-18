<?php

namespace Jmbermudo\SGR3Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * En este método tendremos que crear toda la información a mostrar en
         * los distintos paneles del dashboard
         */
        
        $usuario = $this->getUser();
        
        //Empezaremos por las reuniones creadas de cada usuario
        $misReuniones = $usuario->getCreadorDeReuniones();
        
        //Ahora las reuniones a las que me han invitado:
        $misInvitaciones = $usuario->getReunionesPendientes();
        
        return $this->render('JmbermudoSGR3Bundle:Default:index.html.twig', 
                array(
                    'reuniones' => $misReuniones,
                    'invitaciones' => $misInvitaciones,
                    'intervalo' => $this->container->getParameter('duracion_reunion')
                    )
                );
    }
}
