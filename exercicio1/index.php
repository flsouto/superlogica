<?php
// Comente essa linha em produção ;)
error_reporting(E_ALL);

// Inclui autoloader para não precisar incluir as classes manualmente
require(__DIR__."/autoload.php");

// Instancia alguns objetos
$db = new \Exercicio1\Database\Users();
$page = new Exercicio1\View('page');
$form = new Exercicio1\View('form');

// Cria a tabela se ainda não existir
// Obs.: é melhor comentar essa linha em produção!!
$db->createTableOnce();

// Se usuário enviou o form:
if($_SERVER['REQUEST_METHOD']==='POST'){
    // Tenta Inserir
    try{
        $id = $db->insert($_POST);
        echo $page->set('content', "Usuário inserido com sucesso, ID: $id");
        die();
    } catch(Exception $e){
        $form->set('error', $e->getMessage());
    }
    // Persiste os dados para o usuário não precisar redigitar tudo
    $form->merge($_POST);
}

// Compõe a página utilizando o objeto form como conteúdo
echo $page->set('content', $form);
