<?php

namespace MoiKubki\FootballBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('v','integer', array('label' => 'Очки за победу', 'attr' => array('value' => 3)))
            ->add('n', 'integer', array('label' => 'Очки за ничью', 'attr' => array('value' => 1)))
            ->add('p', 'integer', array('label' => 'Очки за поражение', 'attr' => array('value' => 0)))
            ->add('u', 'integer', array('label' => 'Число учасников', 'attr' => array('value' => 4)));
    }

    public function getName()
    {
        return 'settings';
    }

    public function getParent()
    {
        return 'form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MoiKubki\FootballBundle\Entity\Settings',
            'auto_initialize' => true,
        ));
    }
} 