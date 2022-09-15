<?php
namespace Exercicio1\Validators;

class MinWords extends AbstractValidator {

    private $min;

    function __construct(int $min){
        $this->min = $min;
    }

    function validate($input) : bool{
        return count(explode(" ", $input)) >= $this->min;
    }

}
