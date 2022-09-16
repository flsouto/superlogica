<?php

/**
 * Coverte caminhos de classes para caminhos de arquivos
 * removendo "Exercicio1" e adicionando a extensão ".php"
 * Se encontrar o arquivo, inclui ele, que deve conter a definição da classe
 */
spl_autoload_register(function($class){
    $path = str_replace("Exercicio1\\","",$class);
    $path = str_replace("\\","/", $path).'.php';
    $path = __DIR__."/libs/$path";
    if(!file_exists($path)){
        throw new \Exception("Classe não encontrada: $path");
    }
    require($path);
});
