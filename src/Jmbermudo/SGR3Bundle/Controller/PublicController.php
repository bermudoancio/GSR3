<?php

namespace Jmbermudo\SGR3Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        /*
         * Vamos a seleccionar aquellas reservas cuyos invitados hayan aceptado
         * asistir. Se seleccionarán aunque todavía esté pendiente la confirmación
         * de un supuesto responsable de recurso.
         */
        $reservasValidas = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->getReunionesActivas();
        
        return $this->render('JmbermudoSGR3Bundle:Public:index.html.twig', 
            array(
                'reuniones' => $reservasValidas
                )
            );
    }

}
