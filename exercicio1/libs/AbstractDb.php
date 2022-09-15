<?php
namespace Exercicio1;

abstract class AbstractDb{

    protected $tableName;
    protected $pdo;

    function __construct(){
        $this->pdo = new \PDO("sqlite:./exercicio1.db");
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    abstract function getDDL() : string;

    function createTable(){
        $this->pdo->exec($this->getDDL());
    }

    function validateFields($fields){
        $ddl = $this->getDDL();
        foreach($fields as $f){
            if(!strstr($ddl, $f)){
                throw new InvalidArgumentException("Atributo inválido: $f");
            }
        }
    }

    function insert(array $data){
        $this->validateFields(array_keys($data));
        $cols = array_keys($data);
        $holders = array_map(function($col){ return ':'.$col; },$cols);
        $holders = implode(",", $holders);
        $cols = implode(",",$cols);
        $query = "INSERT INTO $this->tableName ($cols) VALUES($holders)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);
        return $this->pdo->query("SELECT last_insert_rowid();")->fetch(\PDO::FETCH_COLUMN);
    }

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

    function exists($field, $value){
        $result = $this->select(["id"],[$field=>$value],'id','DESC',1);
        return count($result) > 0;
    }
}
