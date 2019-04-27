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

    
}
