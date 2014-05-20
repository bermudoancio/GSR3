<?php

namespace Jmbermudo\SGR3Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PreReservaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', 'date', array(
                    'widget' => 'single_text',
                    'format' => \IntlDateFormatter::MEDIUM
                ))
            ->add('horaInicio', 'time', array(
                    'input'  => 'datetime',
                    'widget' => 'single_text',
                ))
            ->add('horaFin', 'time', array(
                    'input'  => 'datetime',
                    'widget' => 'single_text',
                ))
            ->add('recurso')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jmbermudo\SGR3Bundle\Entity\PreReserva'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jmbermudo_sgr3bundle_prereserva';
    }
}
