<?php

namespace Jmbermudo\SGR3Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Jmbermudo\SGR3Bundle\Entity\PreReserva;
use Jmbermudo\SGR3Bundle\Form\PreReservaType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * PreReserva controller.
 *
 */
class PreReservaController extends Controller
{
    
    /**
     * Esta función mostrará el formulario para que el responsable de un recurso
     * acepte o rechace la solicitud de reunión
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param integer $id El identificador de la prereserva
     */
    public function respuestaResponsableShowAction(Request $request, $id)
    {
        /*
         * Comprobamos los permisos y existencia de recursos.
         * Este método lanza las excepciones oportunas que darán lugar a los mensajes
         * de error oportunos si hubiera algún error.
         */
        $this->checkResponsableRecurso($request, $id);
        
        $em = $this->getDoctrine()->getManager();

        $preReserva = $em->getRepository('JmbermudoSGR3Bundle:PreReserva')->find($id);
        
        //Si no ha habido excepciones, continuamos.
        //Comprobamos que la pre-reserva no esté aceptada ya
        if($preReserva->getAceptada()){
            // add flash messages
            $request->getSession()->getFlashBag()->add(
                    'error', $this->get('translator')->trans('reunion.prereserva_ya_aceptada')
            );

            return $this->redirect($this->generateUrl('jmbermudo_sgr3_homepage'));
        }
        
        $form = $this->createResponsableForm($preReserva->getId());
        
        return $this->render('JmbermudoSGR3Bundle:PreReserva:prereserva_autorizacion.html.twig', array(
            'preReserva'      => $preReserva,
            'form'   => $form->createView(),
        ));
    }
    
    public function respuestaResponsableAction(Request $request, $id)
    {
        /*
         * Comprobamos los permisos y existencia de recursos.
         * Este método lanza las excepciones oportunas que darán lugar a los mensajes
         * de error oportunos si hubiera algún error.
         */
        $this->checkResponsableRecurso($request, $id);
        
        $em = $this->getDoctrine()->getManager();

        $preReserva = $em->getRepository('JmbermudoSGR3Bundle:PreReserva')->find($id);
        
        //Si no ha habido excepciones, continuamos.
        //Comprobamos que la pre-reserva no esté aceptada ya
        if($preReserva->getAceptada()){
            // add flash messages
            $request->getSession()->getFlashBag()->add(
                    'error', $this->get('translator')->trans('reunion.prereserva_ya_aceptada')
            );

            return $this->redirect($this->generateUrl('jmbermudo_sgr3_homepage'));
        }
        $form = $this->createResponsableForm($preReserva->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            //Veamos qué ha respondido el responsable (o el admin)
            if($form->get($this->get('translator')->trans('reunion.aceptar'))->isClicked()){
                //Se acepta la pre-reserva
                $preReserva->setResponsableResponde(true);
                $preReserva->setResponsableAcepta(true);
                
                //"Desanulamos" la pre-reserva en caso de que se hubiera anulado
                $preReserva->setAnulada(false);
                
                //Y avisamos al responsable
                $this->avisaResponsableValidacionPreReserva($request, $preReserva, true);
            }
            else{
                //Ha rechazado la pre-reserva
                $preReserva->setResponsableResponde(true);
                $preReserva->setResponsableAcepta(false);
                
                //Anulamos la pre-reserva
                $preReserva->setAnulada(true);
                
                //Y avisamos al responsable
                $this->avisaResponsableValidacionPreReserva($request, $preReserva, false);
            }
            
            //Guardamos los cambios
            $em->flush();
            
            // add flash messages
            $request->getSession()->getFlashBag()->add(
                    'success', $this->get('translator')->trans('reunion.validacionPreReservaRecursoOK')
            );
            
            return $this->redirect($this->generateUrl('jmbermudo_sgr3_homepage'));
        }
        
        return $this->render('JmbermudoSGR3Bundle:PreReserva:prereserva_autorizacion.html.twig', array(
            'preReserva'      => $preReserva,
            'form'   => $form->createView(),
        ));
    }
    
    private function createResponsableForm($id)
    {
        //Creamos el formulario sin objeto adjunto
        $defaultData = array('prereserva' => $id);
        $form = $this->createFormBuilder($defaultData)
            ->add('prereserva', 'hidden')
            ->add($this->get('translator')->trans('reunion.aceptar'), 'submit')
            ->add($this->get('translator')->trans('reunion.rechazar'), 'submit')
            ->setAction($this->generateUrl('prereserva_respuesta_responsable_action', array('id' => $id)))
            ->getForm();
        
        return $form;
    }
    
    private function checkResponsableRecurso(Request $request, $id)
    {
        /*
         * Primero de todo, realizamos las comprobaciones oportunas:
         *  - La pre-reserva existe y no está anulada
         *  - El recurso pre-reservado tiene responsable
         *  - Este responsable es el usuario que intenta acceder o el administrador
         */
        
        $em = $this->getDoctrine()->getManager();

        $preReserva = $em->getRepository('JmbermudoSGR3Bundle:PreReserva')->find($id);
        
        if(!$preReserva){
            throw $this->createNotFoundException($this->get('translator')->trans('reunion.prereserva_no_existe'));
        }
        
        if($preReserva->getAnulada()){
            throw new AccessDeniedException($this->get('translator')->trans('reunion.prereserva_anulada'));
        }
        
        $recurso = $preReserva->getRecurso();
                
        if($recurso->getResponsable() === null 
                || false === $this->get('security.context')->isGranted('ROLE_ADMIN')
                && $this->getUser() !== $recurso->getResponsable()){
            throw new AccessDeniedException($this->get('translator')->trans('reunion.prereserva_sin_permiso'));
        }
    }
    
    
    private function avisaResponsableValidacionPreReserva($request, $preReserva, $acepta)
    {
        //Valores por defecto suponiendo que acepta
        $asunto = $this->get('translator')->trans('reunion.validacionPreReservaResponsableAcepta');
        $email = $preReserva->getReunion()->getCreador()->getEmail();
        $plantilla = 'JmbermudoSGR3Bundle:PreReserva:email/email_responsable_acepta_' . $request->getLocale() . '.txt.twig';
        if(!$acepta){
            $asunto = $this->get('translator')->trans('reunion.validacionPreReservaResponsableRechaza');
            $plantilla = 'JmbermudoSGR3Bundle:PreReserva:email/email_responsable_rechaza_' . $request->getLocale() . '.txt.twig';
        }
        
        $this->sendMail(
                $asunto,
                $email, 
                $plantilla, 
                array(
                    'preReserva' => $preReserva,
                    'responsable' => $this->getUser()
                )
            );
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
}
