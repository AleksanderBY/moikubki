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
            ->add('country', 'hidden', array('attr'=> array('name' => 'country')))
            ->add('administrative_area_level_1', 'hidden', array('attr'=> array('data-geo' => 'administrative_area_level_1')))
            ->add('administrative_area_level_2', 'hidden', array('attr'=> array('data-geo' => 'administrative_area_level_2')))
            ->add('locality', 'hidden', array('attr'=> array('data-geo' => 'locality')))
            ->add('sublocality', 'hidden', array('attr'=> array('data-geo' => 'sublocality')))
            ->getForm();

        return $this->render('MoiKubkiHomeBundle:Form:geoAdminUnit.html.twig', array('form' => $form->createView()));
    }
}
