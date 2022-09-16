<?php

namespace Exercicio1;

/**
 * Esta classe permite renderizar templates dentro da pasta ../views
 * Você deve instanciar apenas o nome do arquivo sem a caminho nem a extensão
 * e depois ir setando as variáveis esperadas pelo template
 * Após configurar as variáveis basta dar echo $view para renderizar
 *
 */
class View{

    /**
     * Contem as variáveis setadas para o template consumir
     * @var array
     */
    protected $vars = [];

    function __construct($name){
        $this->file = __DIR__."/../views/$name.phtml";
        if(!file_exists($this->file)){
            throw new \InvalidArgumentException("View não existente: $name");
        }
    }

    /**
     * Seta várias chaves de uma só vez
     *
     * @param array $data
     * @return $this
     */
    function merge(array $data){
        foreach($data as $k => $v){
            $this->vars[$k] = $v;
        }
        return $this;
    }

    /**
     * Seta apenas uma variável
     *
     * @param $k
     * @param $v
     * @return $this
     */
    function set($k, $v){
        $this->vars[$k] = $v;
        return $this;
    }

    /**
     * Renderiza a view quando alguém fizer echo $this
     * @return string
     */
    function __toString(){
        extract($this->vars);
        ob_start(); # a melhor função do PHP :)
        require($this->file);
        return ob_get_clean(); # a segunda melhor função do PHP :)
    }
}
