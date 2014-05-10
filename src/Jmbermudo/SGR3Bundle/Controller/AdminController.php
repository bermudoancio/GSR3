<?php

namespace Jmbermudo\SGR3Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function listarRecursosAction($filtro = '')
    {
        //Creamos la instancia del repositorio
        $repository = $this->getDoctrine()->getRepository('JmbermudoSGR3Bundle:Recurso');
        
        $recursos = $repository->findAll();
        
        return $this->render('JmbermudoSGR3Bundle:Admin:listarRecursos.html.twig', array(
            'recursos' => $recursos,
        ));
    }
    
    public function addRecursoAction()
    {
        
    }
}
