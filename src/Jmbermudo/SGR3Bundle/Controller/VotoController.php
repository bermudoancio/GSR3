<?php

namespace Jmbermudo\SGR3Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Jmbermudo\SGR3Bundle\Entity\Voto;

class VotoController extends Controller
{
    
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Vamos a llamar a un método que comprobará si el usuario puede o no puede
        //votar para esta reunión
        $reunion = $this->usuarioPuedeVotar($id, $em);
        
        $usuario = $this->getUser();
        
        $votos = $em->getRepository('JmbermudoSGR3Bundle:Voto')->getVotosUsuario($usuario, $reunion);
        
        $formulario = $this->generaFormulario($request, $reunion, $votos);
        
        return $this->render('JmbermudoSGR3Bundle:Voto:votacion.html.twig', array(
            'reunion'=> $reunion,
            'votos' => $votos,
            'form'   => $formulario->createView(),
        ));
    }
    
    /**
     * Registra la votaciÃ³n de un usuario invitado a la reuniÃ³n
     * @param type $id Id de la ReuniÃ³n para la que se vota
     */
    public function votacionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Lo primero será ver para qué reunión está votando. El parámetro viene oculto
        $params = $request->request->all();
        $reunion_id = $params['form']['reunion'];
        
        //Vamos a llamar a un método que comprobará si el usuario puede o no puede
        //votar para esta reunión
        $reunion = $this->usuarioPuedeVotar($reunion_id, $em);
        
        $usuario = $this->getUser();
        
        $votos = $em->getRepository('JmbermudoSGR3Bundle:Voto')->getVotosUsuario($usuario, $reunion);
        
        $formulario = $this->generaFormulario($request, $reunion, $votos);
        
        $formulario->handleRequest($request);
        
        if ($formulario->isValid()) {
            
            //Primero anulamos los votos anteriores
            $res = $em->getRepository('JmbermudoSGR3Bundle:Voto')->anulaVotoUsuarioReunion($usuario, $reunion);
            
            //Si la anulación de los votos falla, terminamos
            if(!$res){
                //error 500 
                throw new \Exception($this->get('translator')->trans('global.errorBD'));
            }
            
            //Y ahora guardamos los nuevos
            foreach($reunion->getPrereservas() as $preReserva){
                //Si el voto viene, es que el usuario lo ha votado, si no no
                $voto = new Voto();
                $voto->setFecha(new \DateTime());
                $voto->setPrereserva($preReserva);
                $voto->setUsuario($usuario);
                $voto->setValido(true);
                
                $id_voto = 'voto_' . $preReserva->getId() . '_' . $this->getUser()->getId();
                if (array_key_exists($id_voto, $params['form'])){
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
            
            // add flash messages
            $request->getSession()->getFlashBag()->add(
                    'success', $this->get('translator')->trans('voto.votacionOK')
            );
        }
        
        //El formulario no es válido
        return $this->redirect($this->generateUrl('jmbermudo_sgr3_homepage'));
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
    
    /**
     * Determina si un usuario puede votar en una reunión. tiene en cuenta los
     * siguientes factores:
     *      - Está invitado
     *      - La reunión es válida
     *      - La fecha de votación todavía está activa
     * @param type $request
     * @param type $reunion
     * 
     * @return Reunion El objeto reunión si no se ha producido ningún problema
     * para que el usuario pueda votar
     */
    private function usuarioPuedeVotar($reunion_id, $em)
    {
        $reunion = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->find($reunion_id);
        
        if(!$reunion){
            $this->createNotFoundException($this->get('translator')->trans('reunion.notFound'));
        }
        
        //Vamos a ver si la reunión se ha cancelado
        if ($reunion->getAnulada())
        {
            throw new \Exception($this->get('translator')->trans('reunion.anulada'));
        }
        
        $invitados = $reunion->getInvitados();
        
        $usuario = $this->getUser();
        
        //Si el usuario no está invitado, no puede participar
        if(!$invitados->contains($usuario)){
            throw new AccessDeniedException($this->get('translator')->trans('voto.no_invitado'));
        }
        
        //Vamos a calcular cuándo era la fecha máxima para votar de la reunión
        $fecha_actual = new \DateTime('', new \DateTimeZone($this->container->getParameter('timezone')));
        
        $fecha_max_reunion = $reunion->getFechaCreacion();
        //Añadimos el número de días que el usuario tenía para votar
        $fecha_max_reunion->add(new \DateInterval('P' . $this->container->getParameter('duracion_reunion') . 'D'));
        
        //Si la reunión ya ha pasado su fecha máxima de voto, no puede votar
        //Sólo tendremos en cuenta el día, no la hora
        $fecha_actual_dia = $fecha_actual->format('Y-m-d');
        $fecha_max_reunion_dia = $fecha_max_reunion->format('Y-m-d');
        
        if($fecha_actual_dia > $fecha_max_reunion_dia){
            throw new \Exception($this->get('translator')->trans('reunion.fechaExpirada'));
        }
        
        //Si todo lo anterior pasa sin lanzar excepciones, el usuario puede votar
        return $reunion;
    }

}
