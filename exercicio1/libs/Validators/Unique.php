<?php
namespace Exercicio1\Validators;

use Exercicio1\AbstractDb;

class Unique extends AbstractValidator {

    private $db;
    private $field;

    function __construct(AbstractDb $db, string $field){
        $this->db = $db;
        $this->field = $field;
    }

    function validate($input) : bool{
        return !$this->db->exists($this->field, $input);
    }

}
