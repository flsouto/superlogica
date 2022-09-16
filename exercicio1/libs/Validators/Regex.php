<?php
namespace Exercicio1\Validators;

class Regex extends AbstractValidator {

    private $regex;

    function __construct(string $regex){
        $this->regex = $regex;
    }

    function validate($input) : bool{
        return (bool)preg_match($this->regex, $input);
    }

}
