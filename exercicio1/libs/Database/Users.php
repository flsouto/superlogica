<?php
namespace Exercicio1\Database;

use Exercicio1\Validation;
use Exercicio1\Validators\CEP;
use Exercicio1\Validators\Email;
use Exercicio1\Validators\MinWords;
use Exercicio1\Validators\MinLength;
use Exercicio1\Validators\Regex;
use Exercicio1\Validators\Unique;

class Users extends AbstractTable
{
    /**
     * @var string $tableName Define o nome da tabela
     */
    protected $tableName = 'users';

    /**
     * Valida os dados de usuário antes de inserir
     * @param array $data
     * @return int
     * @throws \Exception
     */
    function insert(array $data) : int{

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
        return parent::insert($data);

    }

    /**
     * Define o DDL dessa tabela
     * @return string
     */
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
