<?php
namespace Exercicio1;

use Exercicio1\Validators\Alpha;
use Exercicio1\Validators\MinWords;
use Exercicio1\Validators\Unique;

class UsersDb extends AbstractDb
{
    function insert(array $data){
        $v = new Validation();
        // Adiciona algumas regras para os campos
        $v->add('name', new MinWords(2), 'Informe seu nome e sobre!');
        $v->add('name', new Alpha(), 'Nome só pode conter letras!');
        $v->add('userName', new Unique($this,'username'), 'Nome só pode conter letras!');
        $v->add('zipCode', new CEP(), 'Cep inválido!');
        $v->add('email', new Email(), 'Email inválido!');
        $v->add('email', new Unique('users','email'), 'Email inválido!');
        $v->add('password', new MinLength('8'), 'A senha deve conter no mínimo 8 caracteres!');
        $v->add('password', new Match('8'), 'A senha deve conter no mínimo 8 caracteres!');
        $v->add('password', new Contains(''));
        if($error = $v->validate()){
            throw new Exception("Não foi possível inserir o usuário: $error");
        }
        $stmt = $this->createStatemnt("INSERT INTO users() VALUES(?,?,?,?,?)");
        $stmt->execute();
        return $this->getInsertId();
    }

    function createSchema(){

    }
}
