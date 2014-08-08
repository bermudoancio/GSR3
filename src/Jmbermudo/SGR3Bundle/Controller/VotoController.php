<?php

namespace Jmbermudo\SGR3Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Jmbermudo\SGR3Bundle\Entity\Voto;

class VotoController extends Controller
{
    
    public function showAction(Request $request, $id)
    {
        //Vamos a ver si el usuario estÃ¡ invitado a la reuniÃ³n
        $em = $this->getDoctrine()->getManager();
        
        $reunion = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->find($id);
        $invitados = $reunion->getInvitados();
        
        $usuario = $this->getUser();
        
        //Si el usuario no estÃ¡ invitado, no puede participar
        if(!$invitados->contains($usuario)){
            throw new AccessDeniedException($this->get('translator')->trans('voto.no_invitado'));
        }
        
        $votos = $em->getRepository('JmbermudoSGR3Bundle:Voto')->getVotosUsuario($usuario, $reunion);
        
        $formulario = $this->generaFormulario($request, $reunion, $votos);
        
        return $this->render('JmbermudoSGR3Bundle:Voto:votacion.html.twig', array(
            'reunion'=> $reunion,
            'form'   => $formulario->createView(),
        ));
    }
    
    /**
     * Registra la votaciÃ³n de un usuario invitado a la reuniÃ³n
     * @param type $id Id de la ReuniÃ³n para la que se vota
     */
    public function votacionAction(Request $request)
    {
        //Lo primero será ver para qué reunión está votando. El parámetro viene oculto
        $params = $this->getRequest()->request->all();
        $reunion_id = $params['form']['reunion'];
        
        $em = $this->getDoctrine()->getManager();
        
        $reunion = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->find($reunion_id);
        $invitados = $reunion->getInvitados();
        
        $usuario = $this->getUser();
        
        //Si el usuario no estÃ¡ invitado, no puede participar
        if(!$invitados->contains($usuario)){
            throw new AccessDeniedException($this->get('translator')->trans('voto.no_invitado'));
        }
        
        $votos = $em->getRepository('JmbermudoSGR3Bundle:Voto')->getVotosUsuario($usuario, $reunion);
        
        $formulario = $this->generaFormulario($request, $reunion, $votos);
        
        $formulario->handleRequest($request);
        
        if ($formulario->isValid()) {
            //Recogemos todos los votos
            $parametros = $request->request->all();
            //Primero anulamos los votos anteriores
            $usuario->anulaVotosReunion($reunion_id);
            
            //Y ahora guardamos los nuevos
            foreach($reunion->getPrereservas() as $preReserva){
                //Si el voto viene, es que el usuario lo ha votado, si no no
                $voto = new Voto();
                $voto->setFecha(new \DateTime());
                $voto->setPrereserva($preReserva);
                $voto->setUsuario($usuario);
                $voto->setValido(true);
                if (in_array('voto_' . $preReserva->getId() . '_' . $this->getUser()->getId())){
                    $voto->setAcepta(true);
                }
                else{
                    $voto->setAcepta(false);
                }
                
                //Por último, guardamos el voto
                $em->persist($voto);
            }
            //Y guardamos en la base de datos
            $em->flush();
        }
        
        //El formulario no es válido
        return $this->render('JmbermudoSGR3Bundle:Voto:votacion.html.twig', array(
            'reunion'=> $reunion,
            'form'   => $formulario->createView(),
        ));
    }
    
    private function generaFormulario(Request $request, $reunion, $votos)
    {
        $form = $this->createFormBuilder()
        ->add('reunion', 'hidden', array(
            'data' => $reunion->getId()
        ));
                
        foreach ($reunion->getPrereservas() as $preReserva) {
            //obtenemos el voto del usuario para esta prereserva
            $voto = $this->getVotoDePrereserva($preReserva, $votos);
            $form->add('voto_' . $preReserva->getId() . '_' . $this->getUser()->getId(), 'checkbox', array(
                'data' => $voto->getAcepta(),
                'label' => $this->formatFecha($preReserva->getFecha(), $request) . ' => ' . $this->formatHora($preReserva->getHoraInicio(), $request) . ' - ' . $this->formatHora($preReserva->getHoraFin(), $request),
                'required' => false
            ));
        }
        
        $form->add('submit', 'submit', array('label' => $this->get('translator')->trans('voto.votar')));
        
        //Cambiamos el action
        $form->setAction($this->generateUrl('voto_votar'));
        
        return $form->getForm();
    }
    
    /**
     * Devuelve el voto correspondiente a la prereserva, o un voto vacío en caso de que
     * no exista
     * @param type $prereserva
     * @param type $votos
     * @return null
     */
    private function getVotoDePrereserva($prereserva, $votos)
    {
        foreach ($votos as $voto) {
            if($voto->getPrereserva() === $prereserva){
                return $voto;
            }
        }
        
        return new Voto();
    }

    private function formatFecha(\Datetime $fecha, Request $request)
    {
        $formatterFecha = \IntlDateFormatter::create(
                        $request->getLocale(),
                        \IntlDateFormatter::MEDIUM,
                        \IntlDateFormatter::NONE,
                        $fecha->getTimezone()->getName(),
                        \IntlDateFormatter::GREGORIAN,
                        null
                    );
        
        return $formatterFecha->format($fecha);
    }
    
    private function formatHora(\Datetime $fecha, Request $request)
    {
        $formatterFecha = \IntlDateFormatter::create(
                        $request->getLocale(),
                        \IntlDateFormatter::NONE,
                        \IntlDateFormatter::MEDIUM,
                        $fecha->getTimezone()->getName(),
                        \IntlDateFormatter::GREGORIAN,
                        null
                    );
        
        return $formatterFecha->format($fecha);
    }

}
