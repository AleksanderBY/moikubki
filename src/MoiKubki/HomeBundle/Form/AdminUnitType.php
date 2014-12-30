<?php
/**
 * Created by PhpStorm.
 * User: 111
 * Date: 29.12.14
 * Time: 8:10
 */


namespace MoiKubki\HomeBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class AdminUnitType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
            ->add('country', 'hidden', array('short_name' => true))
            ->add('administrative_area_level_1', 'hidden', array('short_name' => true))
            ->add('administrative_area_level_2', 'hidden', array('short_name' => true))
            ->add('locality', 'hidden', array('short_name' => true))
            ->add('sublocality', 'hidden', array('short_name' => true));
}

    public function getName()
{
    return null;
}

    public function getParent()
    {
        return 'form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'MoiKubki\HomeBundle\Entity\AdminUnit',
    ));
}
} 