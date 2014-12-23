<?php


namespace MoiKubki\FootballBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TournamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('label' => 'Название', 'attr' => array('placeholder' => 'Чемпионат школы №х среди 11-х классов')))
            ->add('sezon','text', array('label' => 'Сезон', 'attr' => array('placeholder' => '2014-2015 или №1')))
            ->add('settings', new SettingsType(), array('label' => 'Установки:'))
            ->add('description', 'textarea', array('label' => 'Описание', 'attr' => array('placeholder' => 'Описание Вашего турнира (не более 255 символов)')));
    }

    public function getName()
    {
        return 'tournament';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MoiKubki\FootballBundle\Entity\Tournament',
        ));
    }
} 