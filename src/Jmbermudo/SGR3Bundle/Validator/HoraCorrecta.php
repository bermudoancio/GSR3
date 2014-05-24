<?php
namespace Jmbermudo\SGR3Bundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
/**
 * Description of validarPreReserva
 *
 * @author Jose
 */
class HoraCorrecta extends Constraint
{
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
