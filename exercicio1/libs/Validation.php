<?php
namespace Exercicio1;
use Exercicio1\Validators\AbstractValidator;

/**
 * Classe que permite agregar uma série de validadores
 * Sobre campos vindos de um formulário por exemplo
 * É possível especificar mais de uma regra por campo
 * e customizar as mensagens de erro por regra
 */
class Validation{

    /**
     * Contem todos as regras de validação
     * @var array
     */
    protected $validators = [];

    /**
     * Contem o último erro ocorrido
     * @var string
     */
    protected $error = '';

    /**
     * Adiciona um par de campo e regra de validação
     * Com mensagem de erro opcional
     *
     * @param $field
     * @param AbstractValidator $rule
     * @param string $message
     * @return $this
     */
    function add(string $field, AbstractValidator $rule, string $message = 'Valor inválido'){
        $this->validators[] = [
            'field' => $field,
            'rule' => $rule,
            'message' => $message
        ];
        return $this;
    }

    /**
     * Rode este método quando quiser testar as regras configuradas
     * Retorna true se estiver tudo OK
     * Retorna false se houver pelo menos um erro
     * Utilize o método $this->error() para obter a mensagem de erro
     *
     * @param array $data
     * @return bool
     */
    function validate(array $data) : bool{
        foreach($this->validators as $v){
            $value = $data[$v['field']] ?? null;
            if(!$v['rule']->validate($value)){
                $this->error = $v['message'];
                return false;
            }
        }
        return true;
    }

    /**
     * Retorna último erro ocorrido
     * @return string
     */
    function error() : string{
        return $this->error;
    }
}
