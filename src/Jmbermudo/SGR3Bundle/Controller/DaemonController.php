<?php

namespace Jmbermudo\SGR3Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jmbermudo\SGR3Bundle\Entity\Reunion;

class DaemonController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * En esta acción vamos a realizar todas las tareas necesarias para que
         * el sistema siga en funcionamiento sin problemas. Este script debería
         * ejecutarse automáticamente una vez al día.
         * Se creará una función por cada elemento a actualizar, para poder llevar
         * un mejor control
         */
        
        /*
         * Lo primero será enviar avisos a responsables e invitados sobre la
         * aproximación a la fecha de "fin de voto" de una reunión que todavía no
         * se ha cerrado.
         */
        $this->avisaProximoFin($request);
        
        /*
         * Lo siguiente será aceptar automáticamente las reuniones que hayan expirado
         * hoy y que tengan el porcentaje mínimo de aceptación automática
         */
        $this->aceptaAutomaticamente($request);
        
        /*
         * Ahora vamos a cancelar aquellas reuniones que han expirado hoy sin ser
         * aceptadas
         */
        $this->cancelaExpiradas($request);
    }
    
    private function avisaProximoFin(Request $request)
    {
        /*
         * Lo primero que haremos será obtener las reuniones cuya fecha de finalización
         * sea exactamente X días (parametrizado en el fichero config.yml) desde
         * hoy
         */
        $em = $this->getDoctrine()->getManager();

        $dias = $this->container->getParameter('dias_aviso_fin');
        $fecha_max = new \DateTime();
        $fecha_max->add(new DateInterval('P' . $dias . 'D'));
        
        $reuniones = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->getReunionesExpiranEn($fecha_max);
        
        foreach($reuniones as $reunion){
            //Avisamos al responsable e invitados
            //Formateamos la fecha
            $fecha = $this->formatFecha($fecha_max);
            $this->sendMailsAvisaProximoFin($reunion, $fecha, $this->container->getParameter('porcentaje_aceptacion'));
        }
    }
    
    private function aceptaAutomaticamente(Request $request)
    {
        /*
         * Lo primero que haremos será obtener las reuniones cuya fecha de finalización
         * sea exactamente -1 días 
         */
        $em = $this->getDoctrine()->getManager();

        //restamos un día
        $fecha_max = new \DateTime();
        $fecha_max->sub(new DateInterval('P1D'));
        
        $reuniones = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->getReunionesExpiranEn($fecha_max);
        
        foreach ($reuniones as $reunion) {
            $preReservas = $reunion->getPrereservas();
            
            //TODO: comprobar cuál es la pre-reserva que hay que aceptar.
            
            $em->flush();
            
            //Y avisamos al creador y a los participantes
            $this->avisaAceptacionAutomatica($reunion, $request);
        }
    }
    
    /**
     * Esta función cancelará aquellas reuniones cuya fecha de expiración es ayer
     * y que no están aceptadas ni tienen el porcentaje mínimo para aceptación
     * automática
     */
    private function cancelaExpiradas(Request $request)
    {
        /*
         * Lo primero que haremos será obtener las reuniones cuya fecha de finalización
         * sea exactamente -1 días 
         */
        $em = $this->getDoctrine()->getManager();

        //restamos un día
        $fecha_max = new \DateTime();
        $fecha_max->sub(new DateInterval('P1D'));
        
        $reuniones = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->getReunionesExpiranEn($fecha_max);
        
        foreach ($reuniones as $reunion) {
            //Anulamos la reunión
            $reunion->setAnulada(true);
            $em->flush();
            
            //Y avisamos al creador y a los participantes
            $this->avisaCancelacionAutomatica($reunion, $request);
        }
    }
    
    
    
    private function sendMailsAvisaProximoFin(Reunion $entity, $fecha_max, $porcentaje_min, Request $request)
    {
        //TODO: Calcular el porcentaje de los participantes que han votado
        $porcentaje = 0;
        
        //Avisamos por email al creador
        $this->sendMail(
                $this->get('translator')->trans('reunion.prox_expiracion',
                        array(
                            '%reunion%' => $entity->getNombrePublico()
                        )),
                $entity->getCreador()->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_expiracion_creador_' . $request->getLocale() . '.txt.twig', 
                    array(
                        'nombre' => $entity->getNombrePublico(),
                        'porcentaje_min' => $porcentaje_min,
                        'porcentaje' => $porcentaje,
                        'fecha_max' => $fecha_max
                    )
                );

        //Y a todos los participantes que no hayan votado
        foreach ($entity->getInvitados() as $invitado) {
            $this->sendMail(
                $this->get('translator')->trans('reunion.prox_expiracion_invitado',
                        array(
                            '%reunion%' => $entity->getNombrePublico()
                        )),
                $invitado->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_expiracion_invitado_' . $request->getLocale() . '.txt.twig', 
                array(
                    'nombre' => $entity->getNombrePublico(),
                    'invitado' => $invitado->getNombre(),
                    'fecha_max' => $fecha_max
                )
            );
        }
    }
    
    private function avisaAceptacionAutomatica(Reunion $entity, Request $request)
    {
        $preReservaAceptada = $entity->getReservaAceptada();
        //Avisamos por email al creador
        $this->sendMail(
                $this->get('translator')->trans('reunion.aceptacion_auto_ok',
                        array(
                            '%reunion%' => $entity->getNombrePublico()
                        )),
                $entity->getCreador()->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_aceptacion_auto_creador_' . $request->getLocale() . '.txt.twig', 
                    array(
                        'nombre' => $entity->getNombrePublico(),
                        'preReserva' => $preReservaAceptada
                    )
                );

        //Y a todos los participantes
        foreach ($entity->getInvitados() as $invitado) {
            $this->sendMail(
                $this->get('translator')->trans('reunion.aceptacion_auto_invitado',
                        array(
                            '%reunion%' => $entity->getNombrePublico()
                        )),
                $invitado->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_aceptacion_auto_invitado_' . $request->getLocale() . '.txt.twig', 
                array(
                    'nombre' => $entity->getNombrePublico(),
                    'invitado' => $invitado->getNombre(),
                    'preReserva' => $preReservaAceptada
                )
            );
        }
    }
    
    private function avisaCancelacionAutomatica(Reunion $entity, Request $request)
    {
        //Avisamos por email al creador
        $this->sendMail(
                $this->get('translator')->trans('reunion.cancelacion_auto_ok',
                        array(
                            '%reunion%' => $entity->getNombrePublico()
                        )),
                $entity->getCreador()->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_cancelacion_auto_creador_' . $request->getLocale() . '.txt.twig', 
                array('nombre' => $entity->getNombrePublico())
                );

        //Y a todos los participantes
        foreach ($entity->getInvitados() as $invitado) {
            $this->sendMail(
                $this->get('translator')->trans('reunion.cancelacion_auto_invitado',
                        array(
                            '%reunion%' => $entity->getNombrePublico()
                        )),
                $invitado->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_cancelacion_auto_invitado_' . $request->getLocale() . '.txt.twig', 
                array(
                    'nombre' => $entity->getNombrePublico(),
                    'invitado' => $invitado->getNombre()
                )
            );
        }
    }
    
    
    /**
     * Método que realiza el envío de emails. Si se cambia el mecanismo, cambiar sólo aquí.
     * @param string $asunto
     * @param string $para
     * @param string $plantilla
     * @param array $parametros
     */
    private function sendMail($asunto, $para, $plantilla, $parametros)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject($this->get('translator')->trans('global.name') . ': ' . $asunto)
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($para)
                ->setBody(
                    $this->renderView(
                        $plantilla,
                        $parametros
                    )
                );            
            $this->get('mailer')->send($message);
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
}
