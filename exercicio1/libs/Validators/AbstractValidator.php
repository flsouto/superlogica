<?php
namespace Exercicio1\Validators;

abstract class AbstractValidator{

    abstract function validate($input) : bool;

}
