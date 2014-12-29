<?php

namespace MoiKubki\FootballBundle\Form\Type;

use MoiKubki\HomeBundle\Form\AdminUnitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TeamFCType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('adminunit', new AdminUnitType(), array('label' =>''))
        ->add('name', 'text', array('label' => 'Название команды'))
        ->add('save', 'submit', array('label' => 'Добавить команду'));
}
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // For Symfony 2.0:
        // $view->set('base_path', $form->getAttribute('base_path'));

        // For Symfony 2.1 and higher:
        $view->vars['originname'] = true;
    }

    public function getName()
{
    return 'teamFC';
}



    public function setDefaultOptions(OptionsResolverInterface $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'MoiKubki\FootballBundle\Entity\TeamFC',
        'originname' => true,
    ));
}
}