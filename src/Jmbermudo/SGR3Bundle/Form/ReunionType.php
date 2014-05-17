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
