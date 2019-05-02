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


}
