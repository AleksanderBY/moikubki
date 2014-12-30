<?php

namespace MoiKubki\FootballBundle\Form\Type;

use MoiKubki\HomeBundle\Form\AdminUnitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TeamFCType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('name', 'text', array('label' => 'Название команды'));
}

    public function getName()
{
    return 'teamFC';
}



    public function setDefaultOptions(OptionsResolverInterface $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'MoiKubki\FootballBundle\Entity\TeamFC',
    ));
}
}