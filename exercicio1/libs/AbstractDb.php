<?php
namespace Exercicio1;

abstract class AbstractDb{

    function insert(array $data) : int;
    function select(array $fields) : array;
    function exists($field, $value) : bool;
}
