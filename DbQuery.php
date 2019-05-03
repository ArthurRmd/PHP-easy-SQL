<?php

require './DbConfig.php';

class DbQuery extends DbConfig   
{
    
    protected $connected;
    protected $pdo;


    public function checkConnected()
    {
        if ($this->connected === null || $this->connected === false) {
            return false;
        }else {
            return true;
        }
    }

    public function getConnection()
    {
        if ($this->checkConnected()) {
            return $this->pdo;
        }else {
            $this->pdo = $this->getPdo();

            if ($this->getPdo() !== null ) {
                $this->connected = true; 
            } else {
              die("erreur");  
            }
            
        }
    }

    public function close()
    {
        $this->connected = false; 
        $this->pdo = null; 
    }

    
    public function query($sql, $value =[])
    {

        $this->getConnection();

        if(empty($value)){
            $query = $this->pdo->query($sql);
            if ($query !== false ) {
                $query = true;
            }
        }
        else {
            $query = $this->pdo->prepare($sql);
            $query = $query->execute($value);
        }

        return $query;
    }



    public function select($sql, $value =[])
    {

        $this->getConnection();

        if(empty($value)){
            $query = $this->pdo->query($sql);
            if ($query == false ) {
                die('erreur sql');
            }
        }
        else {
            $query = $this->pdo->prepare($sql);
            $query->execute($value);
        }

        return $query->fetchall();

    }



    public function selectAll($table = null,  $where = []){
        if (!empty($table)) {

            if (!empty($where)) {
                $queryWhere = $this->where($where);
                return $this->select("select * from $table $queryWhere[0]", $queryWhere[1] );
            }
            else {
                return $this->select("select * from $table");

            }
        }
        return null;
    }

    public function find($table = null, $id=null){
        if (!empty($table) && !empty($id)) {
            return $this->select("select * from $table where id = :id", ['id' => $id]);
        }
        return null;
    }

    public function where($array )
    {
        if (!empty($array) && (in_array(count($array), [2,3])) ) {
            
            $column = $array[0];
            $operator = (count($array) == 2) ? '=' : $array[1];
            $value = (count($array) == 2) ? $array[1] : $array[2];

            $query = "where $column $operator :$column";
            return array( $query, [$column => $value] );

        }
        die("erreur");
    }


}
