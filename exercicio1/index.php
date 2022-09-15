<?php
// Inclui autoloader para não precisar incluir as classes manualmente
require(__DIR__."/autoload.php");

// Instancia alguns objetos
$db = new Exercicio1\UsersDb();
$page = new Exercicio1\View('page');
$form = new Exercicio1\View('form');

// Cria a tabela se ainda não existir
// Obs.: é melhor comentar essa linha em produção!!
$db->createSchema();

// Se usuário enviou o form:
if($_SERVER['REQUEST_METHOD']==='POST'){
    // Tenta Inserir
    try{
        $id = $db->insert($_POST);
        $page->set('content', "Usuário inserido com sucesso, ID: $id");
        die($page);
    } catch(Exception $e){
        $form->set('error', $e->getMessage());
    }

    $form->merge($_POST);
}

// Compõe a página utilizando o objeto form como conteúdo
$page->set('content', $form);
echo $page;
