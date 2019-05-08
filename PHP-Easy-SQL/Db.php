<?php

class Db extends DbQuery {


/**
 *  Exemple :
 * 
*   public static function ageBetween( $ageMin , $ageMax)
*   {
*       return self::select('select * from users where age > :ageMin and age < :ageMax', ['ageMin' => $ageMin, 'ageMax' => $ageMax]);
*   }

*/

}