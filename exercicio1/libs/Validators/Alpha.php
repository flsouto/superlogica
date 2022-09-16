<?php
namespace Exercicio1\Validators;

class Alpha extends AbstractValidator {

    function validate($input) : bool{
        return ctype_alpha(str_replace(' ','',$input));
    }

}
