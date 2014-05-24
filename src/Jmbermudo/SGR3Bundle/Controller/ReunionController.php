<?php

namespace Jmbermudo\SGR3Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use \DateTime;
use Jmbermudo\SGR3Bundle\Entity\Reunion;
use Jmbermudo\SGR3Bundle\Entity\PreReserva;
use Jmbermudo\SGR3Bundle\Form\ReunionType;

/**
 * Reunion controller.
 *
 */
class ReunionController extends Controller
{

    /**
     * Lists all Reunion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->findAll();

        return $this->render('JmbermudoSGR3Bundle:Reunion:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Reunion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Reunion();
        //Completamos los campos que no van en el formulario
        $entity->setCreador($this->getUser());
        $entity->setFechaCreacion(new \DateTime);
        $entity->setAnulada(false);
        
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        /*
         * Para ver todas las validaciones del formulario abrir el archivo
         * validation.yml en la carpeta Resources/config del bundle
         */
        
        /*
         * Ahora tenemos que comprobar que el usuario puede crear más reuniones,
         * es decir, no ha superado el límite
         */
        $em = $this->getDoctrine()->getManager();
        $num_reuniones = $em->getRepository('JmbermudoSGR3Bundle:Usuario')->getReunionesActivas($this->getUser());

        if($num_reuniones >= $this->container->getParameter('max_reuniones')){
           $form->addError(new FormError($this->get('translator')->trans('reunion.max_reuniones_superado')));
        }
        
        /*
         * Ahora, de la misma forma procedemos a comprobar el número máximo
         * de pre-reservas efectuadas.
         */
        
        $preReservas = $entity->getPrereservas();
        
        /*
         * Vamos a comprobar si las pre-reservas son válidas
         */
        $mensajes_error = $this->checkPreReservas($request, $preReservas);
        
        if(count($mensajes_error) > 0){
//            foreach ($preReservas as $preReserva) {
//                $obj_serializado = serialize($preReserva);
//                if(array_key_exists($obj_serializado, $mensajes_error)){
//                    foreach ($mensajes_error[$obj_serializado] as $error) {
//                        $form->get('prereservas')->addError($error);
//                    }
//                }
//            }
            
            
            foreach ($mensajes_error as $mensaje) {
                //El mensaje ya está traducido aquí
                $form->addError(new FormError($mensaje));
            }
        }
        
        if($preReservas->count() /* @TODO + $this->getUser()->getPrereservas().count() */ > $this->container->getParameter('max_pre_reservas_total')){
            $form->addError(new FormError($this->get('translator')->trans('reunion.max_prereservas_superado')));
        }

        if ($form->isValid()) {
            
            //Tenemos que darle los valores básicos a la pre-reserva
            foreach ($preReservas as $preReserva) {
                $preReserva->setAnulada(false);
                $preReserva->setReunion($entity);
                
                //comprobamos si el recurso tiene responsable, y le avisamos
                if($preReserva->getRecurso()->getResponsable() !== null){
                    //hay que avisar al responsable
                    $this->avisaResponsable($preReserva, $request);
                }
                
                $preReserva->setResponsableResponde(false);
                $preReserva->setResponsableAcepta(false);
            }
            
            $em->persist($entity);
            $em->flush();
            
            //Todo correcto, terminamos
            
            // add flash messages
            $request->getSession()->getFlashBag()->add(
                    'success', $this->get('translator')->trans('reunion.creacion_ok')
            );
            
            $this->avisaCreacionOk($entity, $request);

            return $this->redirect($this->generateUrl('reunion_show', array('id' => $entity->getId())));
        }

        return $this->render('JmbermudoSGR3Bundle:Reunion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    /**
    * Creates a form to create a Reunion entity.
    *
    * @param Reunion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Reunion $entity)
    {
        $form = $this->createForm(new ReunionType(), $entity, array(
            'action' => $this->generateUrl('reunion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => $this->get('translator')->trans('global.crear')));

        return $form;
    }

    /**
     * Displays a form to create a new Reunion entity.
     *
     */
    public function newAction()
    {
        /*
         * Antes de crear la reunión, comprobaremos que pueda hacerlo por no
         * haber superado el límite
         */
        $em = $this->getDoctrine()->getManager();
        $num_reuniones = $em->getRepository('JmbermudoSGR3Bundle:Usuario')->getReunionesActivas($this->getUser()->getId());

        if($num_reuniones >= $this->container->getParameter('max_reuniones')){
            throw new \Exception($this->get('translator')->trans('reunion.max_reuniones_superado'). ": " . $this->container->getParameter('max_reuniones'));
        }
        
        //Si no ha superado el límite, puede crearla
        $entity = new Reunion();
       
        $form   = $this->createCreateForm($entity);

        return $this->render('JmbermudoSGR3Bundle:Reunion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Reunion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reunion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JmbermudoSGR3Bundle:Reunion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Reunion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reunion entity.');
        }
        
        /*
         * Vamos a comprobar que el usuario tiene acceso para editar esta reunión.
         * Sólo tendrán acceso el creador y los administradores
         */
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')
                && $this->getUser() !== $entity->getCreador()) {
            throw new AccessDeniedException();
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JmbermudoSGR3Bundle:Reunion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Reunion entity.
    *
    * @param Reunion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Reunion $entity)
    {
        $form = $this->createForm(new ReunionType(), $entity, array(
            'action' => $this->generateUrl('reunion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => $this->get('translator')->trans('global.editar')));

        return $form;
    }
    /**
     * Edits an existing Reunion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reunion entity.');
        }
        
        /*
         * Vamos a comprobar que el usuario tiene acceso para editar esta reunión.
         * Sólo tendrán acceso el creador y los administradores
         */
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')
                && $this->getUser() !== $entity->getCreador()) {
            throw new AccessDeniedException();
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            
            //Por último, avisamos de la modificación
            $this->avisaModificacion();
            
            // add flash messages
            $request->getSession()->getFlashBag()->add(
                    'success', $this->get('translator')->trans('reunion.modificacion_ok')
            );

            return $this->redirect($this->generateUrl('reunion_edit', array('id' => $id)));
        }

        return $this->render('JmbermudoSGR3Bundle:Reunion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Reunion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->find($id);
        
        /*
         * Vamos a comprobar que el usuario tiene acceso para editar esta reunión.
         * Sólo tendrán acceso el creador y los administradores
         */
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')
                && $this->getUser() !== $entity->getCreador()) {
            throw new AccessDeniedException();
        }
        
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Reunion entity.');
            }
            //No la borramos, sino que la marcamos como anulada
            $entity->setAnulada(true);
            $em->flush();
            
            //Por último, avisamos de la cancelación
            $this->avisaCancelacion($entity, $request);
            
            // add flash messages
            $request->getSession()->getFlashBag()->add(
                    'success', $this->get('translator')->trans('reunion.cancelacion_ok')
            );
        }

        return $this->redirect($this->generateUrl('jmbermudo_sgr3_homepage'));
    }

    /**
     * Creates a form to delete a Reunion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reunion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => $this->get('translator')->trans('global.eliminar')))
            ->getForm()
        ;
    }
    
    /**
     * Esta función comprobará si las prereservas de una reunión son válidas.
     * Para ello, comprobaremos una a una si existe alguna imposibilidad de realizar
     * las prereservas con otras ya existentes.
     * @param array $preReservas
     * @return array $mensajes Los mensajes de error encontrados o un array vacío si todo ha salido bien
     */
    private function checkPreReservas(Request $request, \Doctrine\Common\Collections\ArrayCollection $preReservas)
    {
        $mensajes = array();
        
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JmbermudoSGR3Bundle:PreReserva');
        
        foreach ($preReservas as $preReserva) {
           /*
            * Ahora vamos a hacer dos comprobaciones básicas:
            *  1: La fecha es posterior o igual al día de hoy
            *  2: La hora de fin es posterior a la hora de inicio
            */
            $fechaInicioConHoraInicio = $preReserva->getFecha();
            //Lo que hacemos es ponerle la hora inicio a la fecha para comparar
            $fechaInicioConHoraInicio->setTime($preReserva->getHoraInicio()->format('H'), $preReserva->getHoraInicio()->format('i'));
            
            if ($fechaInicioConHoraInicio <= new DateTime("now")){
                $mensajes[] = $this->get('translator')->trans('reunion.errorFechaAnterior');
            }
            
            if ($preReserva->getHoraInicio() >= $preReserva->getHoraFin()){
                $mensajes[] = $this->get('translator')->trans('reunion.errorHoraIncongruente');
            }
            
            
            //Obtenemos la lista de reservas del recurso para ese día
            $reservas = $repo->getPrereservasRecurso($preReserva->getRecurso(), $preReserva->getFecha());
            /*
             * Entiendase la reserva como las que ya están efectuadas (aceptadas o pendientes)
             * y las prereservas las que se están intentando efectuar ahora
             */
            foreach($reservas as $reserva) {
                if($this->solapa($preReserva, $reserva)){
                    //Formateemos las fechas antes de mostrarlas
                    $formatterFecha = \IntlDateFormatter::create(
                        $request->getLocale(),
                        \IntlDateFormatter::MEDIUM,
                        \IntlDateFormatter::NONE,
                        $preReserva->getFecha()->getTimezone()->getName(),
                        \IntlDateFormatter::GREGORIAN,
                        null
                    );
                    
                    $formatterHora = \IntlDateFormatter::create(
                        $request->getLocale(),
                        \IntlDateFormatter::NONE,
                        \IntlDateFormatter::MEDIUM,
                        $preReserva->getFecha()->getTimezone()->getName(),
                        \IntlDateFormatter::GREGORIAN,
                        null
                    );
                    
                    
                    $mensajes[] = $this->get('translator')->trans('reunion.solapa', array(
                        '%recurso%' => $preReserva->getRecurso()->getNombre(),
                        '%fecha%' => $formatterFecha->format($preReserva->getFecha()->getTimestamp()),
                        '%hora_inicio%' => $formatterHora->format($reserva->getHoraInicio()->getTimestamp()),
                        '%hora_fin%' => $formatterHora->format($reserva->getHoraFin()->getTimestamp())
                    ));
                }
            }
        }
        
        return $mensajes;
    }
    
    /**
     * Esta función calcula si dos pre-reservas se solapan entre ellas
     * @param \Jmbermudo\SGR3Bundle\Entity\PreReserva $preReserva
     * @param \Jmbermudo\SGR3Bundle\Entity\PreReserva $reserva
     * @return boolean
     */
    private function solapa(PreReserva $preReserva, PreReserva $reserva){
        $solapa = false;
        /*
         * Al obtener un campo Time de la BD el sistema le incorpora la fecha
         * actual. Para ello, lo que haremos será "falsear" la fecha para todos
         * Para igualar el día, mes y año
         */
        $Hi = $reserva->getHoraInicio()->setDate(2000, 01, 01);
        $Hf = $reserva->getHoraFin()->setDate(2000, 01, 01);
        $hi = $preReserva->getHoraInicio()->setDate(2000, 01, 01);
        $hf = $preReserva->getHoraFin()->setDate(2000, 01, 01);
        
        $c1 = $hi <= $Hi;
        $c2 = $hf > $Hi;
        $c3 = $hi > $Hi;
        $c4 = $hi < $Hf;
        
        if($c1 && $c2 || $c3 && $c4) {
            //Si se da alguno de estos casos, las reservas se solapan
            $solapa = true;
        }
        
        return $solapa;
    }
    
    private function avisaCreacionOk(Reunion $entity, Request $request)
    {
        //Avisamos por email al creador
        $this->sendMail(
                $this->get('translator')->trans('reunion.creacion_ok'),
                $entity->getCreador()->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_admin_' . $request->getLocale() . '.txt.twig', 
                array('nombre' => $entity->getNombrePublico())
                );

        //Y a todos los participantes
        foreach ($entity->getInvitados() as $invitado) {
            $this->sendMail(
                $this->get('translator')->trans('reunion.invitado'),
                $invitado->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_invitado_' . $request->getLocale() . '.txt.twig', 
                array(
                    'nombre' => $entity->getNombrePublico(),
                    'invitado' => $invitado->getNombre(),
                    'creador' => $entity->getCreador(),
                    'enlace' => ''
                )
            );
        }
    }
    
    private function avisaCancelacion(Reunion $entity, Request $request)
    {
        //Avisamos por email al creador
        $this->sendMail(
                $this->get('translator')->trans('reunion.cancelacion_ok'),
                $entity->getCreador()->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_cancelacion_creador_' . $request->getLocale() . '.txt.twig', 
                array('nombre' => $entity->getNombrePublico())
                );

        //Y a todos los participantes
        foreach ($entity->getInvitados() as $invitado) {
            $this->sendMail(
                $this->get('translator')->trans('reunion.cancelacion_invitado',
                        array(
                            '%reunion%' => $entity->getNombrePublico()
                        )),
                $invitado->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_cancelacion_invitado_' . $request->getLocale() . '.txt.twig', 
                array(
                    'nombre' => $entity->getNombrePublico(),
                    'invitado' => $invitado->getNombre()
                )
            );
        }
    }
    
    private function avisaModificacion(Reunion $entity, Request $request)
    {
        //Avisamos por email al creador
        $this->sendMail(
                $this->get('translator')->trans('reunion.modificacion_ok'),
                $entity->getCreador()->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_modificacion_creador_' . $request->getLocale() . '.txt.twig', 
                array('nombre' => $entity->getNombrePublico())
                );

        //Y a todos los participantes
        foreach ($entity->getInvitados() as $invitado) {
            $this->sendMail(
                $this->get('translator')->trans('reunion.modificacion_invitado',
                        array(
                            '%reunion%' => $entity->getNombrePublico()
                        )),
                $invitado->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_modificacion_invitado_' . $request->getLocale() . '.txt.twig', 
                array(
                    'nombre' => $entity->getNombrePublico(),
                    'invitado' => $invitado->getNombre()
                )
            );
        }
    }
    
    private function avisaResponsable(PreReserva $entity, Request $request)
    {
        //Avisamos por email al creador
        $this->sendMail(
                $this->get('translator')->trans('reunion.aviso_responsable'),
                $entity->getRecurso()->getResponsable()->getEmail(), 
                'JmbermudoSGR3Bundle:Reunion:email/email_aviso_responsable_' . $request->getLocale() . '.txt.twig', 
                array(
                    'responsable' => $entity->getRecurso()->getResponsable()->getNombre(),
                    'preReserva' => $entity,
                    'enlace' => ''
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