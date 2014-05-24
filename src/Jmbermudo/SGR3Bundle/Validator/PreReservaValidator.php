<?php
namespace Jmbermudo\SGR3Bundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Jmbermudo\SGR3Bundle\Entity\Reunion;
use Jmbermudo\SGR3Bundle\Entity\PreReserva;

/**
 * Description of PreReservaValidator
 *
 * @author Jose
 */
class HoraCorrectaValidator extends ConstraintValidator
{
    public function validate(Reunion $reunion, Constraint $constraint)
    {
        if (!$reunion instanceof PreReserva) {
            throw new UnexpectedTypeException($reunion, 'Jmbermudo\SGR3Bundle\Entity\Reunion');
        }
        
        foreach ($reunion->getPrereservas() as $index => $preReserva) {
            if (!$preReserva->getAnulada()) { // no validamos las anuladas
                $mensajes = $this->preReservaValida($preReserva);
                if (!empty($mensajes)) {
                    foreach($mensajes as $mensaje){
                        $this->context->addViolationAt("PreReservas[$index]", $mensaje, array(), $preReserva);
                    }
                }
            }
        }
    }
    
    private function preReservaValida(PreReserva $preReserva)
    {
        $mensajes = array();
        /*
         * Ahora vamos a hacer dos comprobaciones básicas:
         *  1: La fecha es posterior o igual al día de hoy
         *  2: La hora de fin es posterior a la hora de inicio
         */
        $fechaInicioConHoraInicio = $preReserva->getFecha();
        //Lo que hacemos es ponerle la hora inicio a la fecha para comparar
        $fechaInicioConHoraInicio->setTime($preReserva->getHoraInicio()->format('H'), $preReserva->getHoraInicio()->format('i'));

        if ($fechaInicioConHoraInicio <= new DateTime("now")) {
            $mensajes[] = 'reunion.errorFechaAnterior';
        }

        if ($preReserva->getHoraInicio() >= $preReserva->getHoraFin()) {
            $mensajes[] = 'reunion.errorHoraIncongruente';
        }
        
        return $mensajes;
    }

}
