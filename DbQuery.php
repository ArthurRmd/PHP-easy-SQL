<?php

require './DbConfig.php';

class DbQuery extends DbConfig   
{
    
    public static function close()
    {
        self::$pdo = null; 
    }

    
    public static function query($sql, $value =[])
    {

       self::getPdo();

        if(empty($value)){
            $query = self::$pdo->query($sql);
            if ($query !== false ) {
                $query = true;
            }
        }
        else {
            $query = self::$pdo->prepare($sql);
            $query = $query->execute($value);
        }

        return $query;
    }



    public static function select($sql, $value =[])
    {

        self::getPdo();

        if(empty($value)){
            $query = self::$pdo->query($sql);
            if ($query == false ) {
                die('erreur sql');
            }
        }
        else {
            $query = self::$pdo->prepare($sql);
            $query->execute($value);
        }

        return $query->fetchall();

    }



    public static function selectAll($table = null,  $where = []){
        if (!empty($table)) {

            if (!empty($where)) {
                $queryWhere = self::where($where);
                return self::select("select * from $table $queryWhere[0]", $queryWhere[1] );
            }
            else {
                return self::select("select * from $table");
            }
        }
        return null;
    }

    public static function find($table = null, $id=null){
        if (!empty($table) && !empty($id)) {
            return self::select("select * from $table where id = :id", ['id' => $id]);
        }
        return null;
    }

    private static function where($array )
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
