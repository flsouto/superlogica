<?php

spl_autoload_register(function($class){
    $path = str_replace("Exercicio1\\","",$class);
    $path = str_replace("\\","/", $path).'.php';
    $path = __DIR__."/libs/$path";
    if(!file_exists($path)){
        die("Classe não encontrada: $path");
    }
    require($path);
});
