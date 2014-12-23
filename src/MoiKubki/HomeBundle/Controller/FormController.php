<?php

namespace MoiKubki\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FormController extends Controller
{
    public function geoAdminUnitAction()
    {
        $form = $this->createFormBuilder()
            ->add('settlement', 'text', array('label' => 'Населенный пункт' , 'label_attr' => array('id'=>'geocomplete')))
            ->add('name', 'text', array('label' => 'Название команды'))
            ->getForm();

        return $this->render('MoiKubkiHomeBundle:Form:geoAdminUnit.html.twig', array('form' => $form->createView()));
    }
}
