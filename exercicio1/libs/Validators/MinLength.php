<?php
namespace Exercicio1\Validators;

class MinLength extends AbstractValidator {

    private $min;

    function __construct(int $min){
        $this->min = $min;
    }

    function validate($input) : bool{
        if(strlen($input) < $this->min){
            return false;
        }
        return true;
    }

}
