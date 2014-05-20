<?php

namespace Jmbermudo\SGR3Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Jmbermudo\SGR3Bundle\Entity\PreReserva;
use Jmbermudo\SGR3Bundle\Form\PreReservaType;

/**
 * PreReserva controller.
 *
 */
class PreReservaController extends Controller
{

    /**
     * Lists all PreReserva entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JmbermudoSGR3Bundle:PreReserva')->findAll();

        return $this->render('JmbermudoSGR3Bundle:PreReserva:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new PreReserva entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new PreReserva();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('prereserva_show', array('id' => $entity->getId())));
        }

        return $this->render('JmbermudoSGR3Bundle:PreReserva:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a PreReserva entity.
    *
    * @param PreReserva $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PreReserva $entity)
    {
        $form = $this->createForm(new PreReservaType(), $entity, array(
            'action' => $this->generateUrl('prereserva_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PreReserva entity.
     *
     */
    public function newAction()
    {
        $entity = new PreReserva();
        $form   = $this->createCreateForm($entity);

        return $this->render('JmbermudoSGR3Bundle:PreReserva:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PreReserva entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JmbermudoSGR3Bundle:PreReserva')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PreReserva entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JmbermudoSGR3Bundle:PreReserva:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing PreReserva entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JmbermudoSGR3Bundle:PreReserva')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PreReserva entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JmbermudoSGR3Bundle:PreReserva:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a PreReserva entity.
    *
    * @param PreReserva $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PreReserva $entity)
    {
        $form = $this->createForm(new PreReservaType(), $entity, array(
            'action' => $this->generateUrl('prereserva_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PreReserva entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JmbermudoSGR3Bundle:PreReserva')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PreReserva entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('prereserva_edit', array('id' => $id)));
        }

        return $this->render('JmbermudoSGR3Bundle:PreReserva:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a PreReserva entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JmbermudoSGR3Bundle:PreReserva')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PreReserva entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('prereserva'));
    }

    /**
     * Creates a form to delete a PreReserva entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prereserva_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
