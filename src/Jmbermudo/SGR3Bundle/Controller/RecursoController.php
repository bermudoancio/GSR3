<?php

namespace Jmbermudo\SGR3Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Jmbermudo\SGR3Bundle\Entity\Recurso;
use Jmbermudo\SGR3Bundle\Form\RecursoType;

/**
 * Recurso controller.
 *
 */
class RecursoController extends Controller
{

    /**
     * Lists all Recurso entities.
     *
     */
    public function indexAction($filtro = '')
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JmbermudoSGR3Bundle:Recurso')->findAll();

        return $this->render('JmbermudoSGR3Bundle:Recurso:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Recurso entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Recurso();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setActivo(true);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('recurso_index'));
        }

        return $this->render('JmbermudoSGR3Bundle:Recurso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Recurso entity.
    *
    * @param Recurso $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Recurso $entity)
    {
        $form = $this->createForm(new RecursoType(), $entity, array(
            'action' => $this->generateUrl('recurso_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => $this->get('translator')->trans('global.crear')));

        return $form;
    }

    /**
     * Displays a form to create a new Recurso entity.
     *
     */
    public function newAction()
    {
        $entity = new Recurso();
        $form   = $this->createCreateForm($entity);

        return $this->render('JmbermudoSGR3Bundle:Recurso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Recurso entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JmbermudoSGR3Bundle:Recurso')->find($id);

        //Si la entidad no está activa no podremos editarla
        if (!$entity || !$entity->getActivo()) {
            throw $this->createNotFoundException('Unable to find Recurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JmbermudoSGR3Bundle:Recurso:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Recurso entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JmbermudoSGR3Bundle:Recurso')->find($id);

        if (!$entity || !$entity->getActivo()) {
            throw $this->createNotFoundException('Unable to find Recurso entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JmbermudoSGR3Bundle:Recurso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Recurso entity.
    *
    * @param Recurso $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Recurso $entity)
    {
        $form = $this->createForm(new RecursoType(), $entity, array(
            'action' => $this->generateUrl('recurso_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => $this->get('translator')->trans('global.editar')));

        return $form;
    }
    /**
     * Edits an existing Recurso entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JmbermudoSGR3Bundle:Recurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException($this->get('translator')->trans('admin.listadoRecursos.noSeEncuentra'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('recurso_edit', array('id' => $id)));
        }

        return $this->render('JmbermudoSGR3Bundle:Recurso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Recurso entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JmbermudoSGR3Bundle:Recurso')->find($id);

            if (!$entity || !$entity->getActivo()) {
                throw $this->createNotFoundException('Unable to find Recurso entity.');
            }
            
            //No lo borraremos, sino que lo marcaremos como no activo
            $entity->setActivo(false);

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('recurso_index'));
    }

    /**
     * Creates a form to delete a Recurso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recurso_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => $this->get('translator')->trans('global.eliminar')))
            ->getForm()
        ;
    }
}
