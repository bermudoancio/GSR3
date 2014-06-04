<?php

namespace Jmbermudo\LsiUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JmbermudoLsiUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
