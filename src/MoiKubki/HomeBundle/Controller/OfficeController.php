<?php

namespace MoiKubki\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OfficeController extends Controller
{
    public function indexAction()
    {
        return $this->render('MoiKubkiHomeBundle:Office:index.html.twig');
    }
}
