<?php
namespace App;

use \PDO;


// Retourne une connexion à la bdd (une instance)
class Connection{
    
    private static $instance = null; // Design Patern SINGLETON
    

    public static function getPDO(): ?PDO
    {

        if(self::$instance === null){
            self::$instance = new PDO('mysql:host=localhost;dbname=themeliov2;charset=utf8', 'root', '',[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO:: ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
        return self::$instance;
        
    }

}