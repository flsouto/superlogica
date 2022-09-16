<?php
namespace Exercicio1\Validators;

/**
 * Todos os validadores devem herdar esta classe
 * e definir o método validate
 * que deve retornar TRUE para "tudo OK"
 * e FALSE para "deu erro"
 */
abstract class AbstractValidator{

    abstract function validate($input) : bool;

}
