<?php
namespace Exercicio1\Validators;

class CEP extends AbstractValidator {

    function validate($input) : bool{
        if(!preg_match('/^[0-9]{5}([- ]?[0-9]{3})?$/', $input)) {
            return false;
        }
        return true;
    }

}
