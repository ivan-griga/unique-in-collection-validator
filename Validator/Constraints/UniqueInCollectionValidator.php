<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * UniqueInCollection Validator checks if one or a set of fields contain unique values
 *
 * @author Ivan Griga <grigaivan2@gmail.com>
 */
class UniqueInCollectionValidator extends ConstraintValidator
{
    /**
     * @var array
     */
    private $collectionValues = array();

    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {  
        if (!$constraint instanceof UniqueInCollection) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\UniqueInCollection');
        }

        if (!is_array($constraint->fields) && !is_string($constraint->fields)) {
            throw new UnexpectedTypeException($constraint->fields, 'array');
        }

        if (null !== $constraint->errorPath && !is_string($constraint->errorPath)) {
            throw new UnexpectedTypeException($constraint->errorPath, 'string or null');
        }
        
        $fields = (array) $constraint->fields;
        
        if (0 === count($fields)) {
            throw new ConstraintDefinitionException('At least one field has to be specified.');
        }        

        $uniqueValuesArr = $this->getFieldsDataArr($value, $fields);

        $errorPath = (null !== $constraint->errorPath) ? $constraint->errorPath : $fields[0];

        if(in_array($uniqueValuesArr, $this->collectionValues)) {
            $this->context->buildViolation($constraint->message)
                ->atPath($errorPath)
                ->addViolation();   
        }

        if (!empty($uniqueValuesArr)) {
            $this->collectionValues[] = $uniqueValuesArr;
        }
    }
    
    private function getFieldsDataArr($object, $fields)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $result = [];

        foreach ($fields as $field)
        {
            $value = $accessor->getValue($object, $field);
            if (isset($value)) {
                $result[$field] = $value;
            }
        }

        return $result;
    }
}
