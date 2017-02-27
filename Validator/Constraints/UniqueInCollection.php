<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @author Ivan Griga <grigaivan2@gmail.com>
 * @Annotation
 */
class UniqueInCollection extends Constraint
{
    public $message = 'This value is already used.';
    
    public $fields = array();
    
    public $errorPath = null;
}
