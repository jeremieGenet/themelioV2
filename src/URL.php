<?php
namespace App;

use Exception;

class URL{

    public static function getInt(string $name, ?int $default = null): ?int
    {
        if(!isset($_GET[$name])) return $default;
        if($_GET[$name] === '0') return 0;
        if(!filter_var($_GET[$name], FILTER_VALIDATE_INT)){
            throw new Exception("Le paramètre d'url : $name, n'est pas un entier!!!");
        }
        return (int)$_GET[$name]; 
    }

    public static function getPositiveInt(string $name, ?int $default = null): ?int
    {
        $paramUrl = self::getInt($name, $default);
        if($paramUrl !== null && $paramUrl <= 0){
            throw new Exception("Le paramètre d'url : $name, n'est pas un entier Positif!!!");
        }
        return $paramUrl;
    }

}