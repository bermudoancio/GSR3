<?php

namespace Jmbermudo\SGR3Bundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends BaseType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        // add your custom field
        $builder->add('nombre');
        $builder->add('apellidos');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jmbermudo\SGR3Bundle\Entity\Usuario',
        ));
    }

    public function getName()
    {
        return 'jmbermudo_user_registration';
    }

}
