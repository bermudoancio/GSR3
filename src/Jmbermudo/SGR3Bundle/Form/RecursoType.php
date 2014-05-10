<?php

namespace Jmbermudo\SGR3Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecursoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('idEscuela')
            ->add('localizacion')
            ->add('responsable')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jmbermudo\SGR3Bundle\Entity\Recurso'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jmbermudo_sgr3bundle_recurso';
    }
}
