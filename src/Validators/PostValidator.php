<?php
namespace App\Validators;

use App\Connection;
use App\Table\PostTable;


// Permet de valider les données d'un champ de formulaire
class PostValidator{

    private $data; // Données reçues pour validation ($_POST)
    /*
    $data = [
        "name" => "qsdfqsdf",
        "slug" => "qsdfqsdf",
        "content" => "qsdfqsdf",
        "createdAt" => "2019-11-03 18:53:57",
        "picture" => [
            "name" => "ann2.jpg",
            "type" => "image/jpeg",
            "tmp_name" => "D:\Code\xampp\tmp\phpBEE6.tmp",
            "error" => 0,
            "size" => 192429
        ]
    ];
    */
    private $errors = [];
    private $postTable;
    private $pdo;
    private $postId;

    // Signature : $v = new PostValidator($_POST, $postTable, $post->getId());
    public function __construct(array $data, PostTable $postTable, ?int $postId = null)
    {
        $this->pdo = Connection::getPDO();
        $this->data = $data; // Données reçues en $_POST du formulaire
        $this->postTable = new PostTable($this->pdo);
        $this->postId = $postId;
    }

    // Vérif si un champs est vide (en param un tableau avec le ou les noms des champs à vérifier) (NE FONCTIONNE PAS SUR LE CHAMPS PICTURE)
    public function fieldEmpty(array $fieldNames): array
    {    
        foreach($fieldNames as $fieldName){
            if(empty($this->data[$fieldName])){
                //dd($this->data[$fieldName], $this->data);
                $this->errors[$fieldName] = "Le champ '{$fieldName}' ne peut pas être vide !";
            }
        }
        //dd($this->errors);
        return $this->errors; // Retourne un tableau d'erreurs OU un tableau vide
        //RETOURNE ex :
        // array:[
        //     "name" => "Le champs name ne peut pas être vide !"?
        //     "slug" => "Le champs slug ne peut pas être vide !"
        // ]
    }

    public function fieldFileEmpty(array $fieldNames): array
    {
        foreach($fieldNames as $fieldName){
            //dd($this->data[$fieldName]);
            if($this->data[$fieldName]['name'] === ""){
                //dd($this->data[$fieldName], $this->data);
                $this->errors[$fieldName] = "Le champ '{$fieldName}' ne peut pas être vide !";
            }
        }
        //dd($this->errors);
        return $this->errors; // Retourne un tableau d'erreurs OU un tableau vide
    }

    // Vérif la taille d'un champ (min et max)
    public function fieldLength(int $nbMin, int $nbMax, array $fieldNames): array
    {
        foreach($fieldNames as $fieldName){
            if(strlen($this->data[$fieldName]) < $nbMin){
                $this->errors[$fieldName] = "Le champ '{$fieldName}' doit comporter au moins {$nbMin} caractères !";
            }
            if(strlen($this->data[$fieldName]) > $nbMax){
                $this->errors[$fieldName] = "Le champ '{$fieldName}' ne doit pas dépasser {$nbMax} caractères !";
            }
        }
        return $this->errors; // Retourne un tableau d'erreurs OU un tableau vide
    }

    // Vérif si un champ existe déjà dans la bdd (en param un tableau avec le ou les noms des champs à vérifier)  Retourne un tableau d'erreurs OU un tableau vide
    public function fieldExist(array $fieldNames): array
    {
        foreach($fieldNames as $fieldName){
            // Méthode exist() permet de vérif dans la bdd si un champ est déja présent (voir dans Table.php)
            // exists() param 1 = Nom du champ, param2 = valeur du nom du champ, param3 = id du post actuel (en traitement)
            if($this->postTable->exists($fieldName, $this->data[$fieldName], $this->postId)){
                $this->errors[$fieldName] = "Le champ '{$fieldName}' existe déjà !";
            }       
        }
        return $this->errors; // Retourne un tableau d'erreurs OU un tableau vide
    }

    // Vérif si un champ FILE existe déjà dans la bdd
    public function fileExist(array $fieldNames): array
    {
        foreach($fieldNames as $fieldName){
            // Méthode exist() permet de vérif dans la bdd si un champ est déja présent (voir dans Table.php)
            // exists() param 1 = Nom du champ, param2 = valeur du nom du champ, param3 = id du post actuel (en traitement)
            //dd($fieldName, $this->data[$fieldName]['name']);
            if($this->postTable->exists($fieldName, $this->data[$fieldName]['name'], $this->postId)){
                $this->errors[$fieldName] = "Ce fichier '{$fieldName}' existe déjà !";
            }       
        }   
        //dd($this->errors);
        return $this->errors; // Retourne un tableau d'erreurs OU un tableau vide
    }

    // Vérif la taille des champs de type File (max 1Mo)
    public function fileSize(array $fieldNames): array
    {
        foreach($fieldNames as $fieldName){
            //dd($this->data[$fieldName]); // 7 298 383
            if($this->data[$fieldName]['size'] > 1000000){
                $this->errors[$fieldName] = "La taille du fichier '{$fieldName}' ne doit pas dépasser 1Mo !";
            }       
        }
        //dd($this->errors);
        return $this->errors; // Retourne un tableau d'erreurs OU un tableau vide
    }

    public function fileExtension(array $fieldNames): array
    {
        foreach($fieldNames as $fieldName){
            //dd($this->data[$fieldName]); // 7 298 383
            if($this->data[$fieldName] !== 'jpg'){
                $this->errors[$fieldName] = "L'extension du fichier '{$fieldName}' doit être au format 'jpg' !";
            }       
        }
        //dd($this->errors);
        return $this->errors; // Retourne un tableau d'erreurs OU un tableau vide
    }
 
}