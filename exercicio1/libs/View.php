<?php

namespace Exercicio1;

class View{

    protected $vars = [];

    function __construct($name){
        $this->file = __DIR__."/../views/$name.phtml";
        if(!file_exists($this->file)){
            throw new \InvalidArgumentException("View não existente: $name");
        }
    }

    function merge(array $data){
        foreach($data as $k => $v){
            $this->vars[$k] = $v;
        }
        return $this;
    }

    function set($k, $v){
        $this->vars[$k] = $v;
        return $this;
    }

    function __toString(){
        extract($this->vars);
        ob_start();
        require($this->file);
        return ob_get_clean();
    }
}
