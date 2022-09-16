<?php
namespace Exercicio1\Database;

/**
 * Classe que deve ser herdada por todas as tabelas concretas
 * Já provê uma funcionalidade básica para as classes filhas
 * Uma classe concreta só precisa definir tableName e getDDL
 */
abstract class AbstractTable{

    /**
     * @var string $tableName Deve ser sobrescrita por uma tabela concreta
     */
    protected $tableName;

    /**
     * @var \PDO $pdo instancia do PDO
     * @todo criar um singleton para evitar ficar criando varias instancias da conexao
     */
    protected $pdo;

    function __construct(){
        $this->pdo = new \PDO("sqlite:./exercicio1.db");
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * A classe concreta deve implementar esse método
     * retornando um CREATE TABLE xxx
     * @return string
     */
    abstract function getDDL() : string;

    /**
     * Cria a tabela apenas se ainda não existir
     * utilizando o próprio método DDL definido pela classe concreta
     * @return void
     */
    function createTableOnce(){
        $ddl = $this->getDDL();
        if(!stristr($ddl,'IF NOT EXISTS')){
            $ddl = str_replace('TABLE '.$this->tableName,'TABLE IF NOT EXISTS '.$this->tableName,$ddl);
        }
        $this->pdo->exec($ddl);
    }

    /**
     * Este método serve para validar se
     * os campos realmente pertencem a essa tabela
     * utiliza o próprio DDL para tal
     *
     * @param $fields
     * @return void
     */
    function validateFields($fields){
        $ddl = $this->getDDL();
        foreach($fields as $f){
            if(!strstr($ddl, $f)){
                throw new \InvalidArgumentException("Atributo inválido: $f");
            }
        }
    }

    /**
     * Insere um registro na tabela
     * Valida os campos e utiliza prepared statements para ficar seguro
     *
     * @param array $data
     * @return int
     */
    function insert(array $data): int
    {
        $cols = array_keys($data);
        $this->validateFields($cols);
        $holders = array_map(function($col){ return ':'.$col; },$cols);
        $holders = implode(",", $holders);
        $cols = implode(",",$cols);
        $query = "INSERT INTO $this->tableName ($cols) VALUES($holders)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);
        return $this->pdo->query("SELECT last_insert_rowid();")->fetch(\PDO::FETCH_COLUMN);
    }

    /**
     * Permite selecionar colunas específicas dessa tabela
     * Além de permitir filtros, ordenação e limit
     * Utiliza validação dos campos e prepared statements para segurança
     *
     * @param array $fields
     * @param array $where
     * @param $sortBy
     * @param $sortOrder
     * @param $limit
     * @return array
     */
    function select(array $fields, array $where = [], $sortBy='id',$sortOrder='DESC', $limit = 100){
        $all_fields = array_merge($fields, array_keys($where), [$sortBy]);
        $this->validateFields($all_fields);
        if(!in_array($sortOrder,['ASC','DESC'])){
            throw new \InvalidArgumentException("Sort order inválida: $sortOrder");
        }
        $query = "SELECT ".implode(",",$fields);
        $query.= " FROM $this->tableName";
        $where_and = [];
        foreach($where as $k => $v){
            $where_and[] = "$k = :$k";
        }
        if(!empty($where_and)){
            $query.= " WHERE ".implode(" AND ", $where_and);
        }
        $query.= " ORDER BY $sortBy $sortOrder";
        $query.= " LIMIT :limit";
        $stmt = $this->pdo->prepare($query);
        foreach($where as $k => $v){
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(":limit", $limit);
        $stmt->execute();
        $rows = [];
        while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * Reutiliza select acima para verificar se um registro existe, por determinado critério
     * Exemplo: $this->exists('email','fabiolimasouto@gmail.com');
     *
     * @param $field
     * @param $value
     * @return bool
     */
    function exists($field, $value){
        $result = $this->select(["id"],[$field=>$value],'id','DESC',1);
        return count($result) > 0;
    }
}
