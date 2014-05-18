<?php

namespace Jmbermudo\SGR3Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jmbermudo\SGR3Bundle\Entity\Reunion;
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
           $form->addError($this->get('translator')->trans('reunion.max_reuniones_superado'));
        }
        /*
         * @TODO: Ahora, de la misma forma procedemos a comprobar el número máximo
         * de pre-reservas efectuadas.
         */

        if ($form->isValid()) {
            
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
    
    private function avisaCreacionOk(Reunion $entity, Request $request)
    {
        //Avisamos por email al creador
        $message = \Swift_Message::newInstance()
            ->setSubject($this->get('translator')->trans('reunion.creacion_ok'))
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setTo($entity->getCreador()->getEmail())
            ->setBody(
                $this->renderView(
                    'JmbermudoSGR3Bundle:Reunion:email_admin_' . $request->getLocale() . '.txt.twig',
                    array('nombre' => $entity->getNombrePublico())
                )
            );            
        $this->get('mailer')->send($message);

        //Y a todos los participantes
        foreach ($entity->getInvitados() as $invitado) {
            $message = \Swift_Message::newInstance()
                ->setSubject($this->get('translator')->trans('reunion.creacion_ok'))
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($invitado->getEmail())
                ->setBody(
                    $this->renderView(
                        'JmbermudoSGR3Bundle:Reunion:email_invitado_' . $request->getLocale() . '.txt.twig',
                        array('nombre' => $entity->getNombrePublico(),
                            'invitado' => $invitado->getNombre(),
                            'creador' => $entity->getCreador(),
                            'enlace' => ''
                                )
                    )
                );            
            $this->get('mailer')->send($message);
        }
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

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

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
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JmbermudoSGR3Bundle:Reunion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Reunion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('reunion_index'));
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
}
