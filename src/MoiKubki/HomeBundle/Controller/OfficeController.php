<?php

namespace MoiKubki\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OfficeController extends Controller
{
    public function indexAction()
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $user = $this->get('security.context')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();
            $myTournaments = $em->getRepository('MoiKubkiFootballBundle:Tournament')->findBy(array('creator' => $user->getId()));
            return $this->render('MoiKubkiHomeBundle:Office:index.html.twig', array('user' =>$user , 'myTournaments' => $myTournaments));
        }
        return $this->redirect('login');
    }
}
