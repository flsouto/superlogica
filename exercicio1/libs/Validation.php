<?php
namespace Exercicio1;
use Exercicio1\Validators\AbstractValidator;

class Validation{

    protected $validators = [];
    protected $error = '';

    function add($field, AbstractValidator $rule, $message){
        $this->validators[] = [
            'field' => $field,
            'rule' => $rule,
            'message' => $message
        ];
        return $this;
    }
    function validate(array $data){
        foreach($this->validators as $v){
            $value = $data[$v['field']] ?? null;
            if(!$v['rule']->validate($value)){
                $this->error = $v['message'];
                return false;
            }
        }
        return true;
    }
    function error(){
        return $this->error;
    }
}
