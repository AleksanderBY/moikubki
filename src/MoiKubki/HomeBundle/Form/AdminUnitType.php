<?php
/**
 * Created by PhpStorm.
 * User: 111
 * Date: 29.12.14
 * Time: 8:10
 */

namespace MoiKubki\HomeBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class AdminUnitType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
            ->add('country', 'text')
            ->add('administrative_area_level_1', 'hidden')
            ->add('administrative_area_level_2', 'hidden')
            ->add('locality', 'hidden')
            ->add('sublocality', 'hidden');
}
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // For Symfony 2.0:
        // $view->set('base_path', $form->getAttribute('base_path'));

        // For Symfony 2.1 and higher:
        $view->vars['originname'] = $options['originname'];
    }

    public function getName()
{
    return null;
}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'MoiKubki\HomeBundle\Entity\AdminUnit',
        'originname' => true,
    ));
}
} 