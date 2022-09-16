<?php
namespace Exercicio1;

use Exercicio1\Validators\Alpha;
use Exercicio1\Validators\CEP;
use Exercicio1\Validators\Email;
use Exercicio1\Validators\MinWords;
use Exercicio1\Validators\MinLength;
use Exercicio1\Validators\Regex;
use Exercicio1\Validators\Unique;

class UsersDb extends AbstractDb
{
    protected $tableName = 'users';

    function insert(array $data){

        $v = new Validation();

        // Adiciona algumas regras para os campos
        $v->add('name', new MinWords(2), 'Informe seu nome e sobrenome!')
            ->add('userName', new MinLength(3), 'Seu username deve ter no mínimo 3 caracteres!')
            ->add('userName', new Unique($this,'userName'), 'Este username já existe!!')
            ->add('zipCode', new CEP(), 'Cep inválido!')
            ->add('email', new Email(), 'Email inválido!')
            ->add('email', new Unique($this,'email'), 'Este email já está em uso!')
            ->add('password', new MinLength(8), 'A senha deve conter no mínimo 8 caracteres!')
            ->add('password', new Regex("/[a-z]/i"), 'A senha deve conter pelo menos uma letra!')
            ->add('password', new Regex('/[0-9]/'), 'A senha deve conter pelo menos um número!');

        // Valida
        if(!$v->validate($data)){
            throw new \Exception("Não foi possível inserir o usuário: ".$v->error());
        }

        // Delega inserção para a classe pai
        parent::insert($data);

    }

    function getDDL() : string{
        return "
            CREATE TABLE users(
                id integer primary key,
                name text not null,
                userName text not null,
                zipCode text not null,
                email text not null,
                password text not null
            );
        ";

    }
}
