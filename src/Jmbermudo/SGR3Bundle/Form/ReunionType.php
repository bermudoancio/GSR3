<?php

namespace Jmbermudo\SGR3Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReunionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombrePublico')
            ->add('nombrePrivado')
            ->add('descripcion')
            ->add('invitados')
                
            //El campo podrá tener una "colección" de prereservas
            ->add('prereservas', 'collection', array(
                'type' => new PreReservaType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype_name' => '__op_name__',
                )
            );
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jmbermudo\SGR3Bundle\Entity\Reunion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jmbermudo_sgr3bundle_reunion';
    }
}
