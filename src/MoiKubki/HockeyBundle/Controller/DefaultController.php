<?php

namespace Moikubki\HockeyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MoikubkiHockeyBundle:Default:index.html.twig', array('name' => $name));
    }
}
