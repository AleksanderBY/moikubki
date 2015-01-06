<?php

namespace MoiKubki\FootballBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Название этапа'));
    }

    public function getName()
    {
        return 'stage';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MoiKubki\FootballBundle\Entity\Stage',
            'auto_initialize' => true,
        ));
    }
} 