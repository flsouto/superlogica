<?php
namespace Exercicio1\Validators;

class Email extends AbstractValidator {

    function validate($input) : bool{
        return (bool) filter_var($input, FILTER_VALIDATE_EMAIL);
    }

}
