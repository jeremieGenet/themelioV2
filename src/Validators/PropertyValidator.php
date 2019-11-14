<?php
namespace App\Validators;

use App\Connection;
use App\Table\PropertyTable;

class PropertyValidator{

    private $data;
    private $errors = [];
    private $propertyTable;
    private $pdo;
    private $propertyId;

    public function __construct(array $data, PropertyTable $propertyTable, ?int $propertyId = null)
    {
        $this->pdo = Connection::getPDO();
        $this->data = $data;
        $this->propertyTable = new PropertyTable($this->pdo);
        $this->propertyId = $propertyId;
    }

    public function fieldEmpty(array $fieldNames): array
    {    
        foreach($fieldNames as $fieldName){
            if(empty($this->data[$fieldName])){
                $this->errors[$fieldName] = "Le champ '{$fieldName}' ne peut pas être vide !";
            }
        }
        return $this->errors;
    }

    public function fieldFileEmpty(array $fieldNames): array
    {
        foreach($fieldNames as $fieldName){
            if($this->data[$fieldName]['name'] === ""){
                $this->errors[$fieldName] = "Le champ '{$fieldName}' ne peut pas être vide !";
            }
        }
        return $this->errors;
    }

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
        return $this->errors;
    }

    public function fieldExist(array $fieldNames): array
    {
        foreach($fieldNames as $fieldName){
            if($this->propertyTable->exists($fieldName, $this->data[$fieldName], $this->propertyId)){
                $this->errors[$fieldName] = "Le champ '{$fieldName}' existe déjà !";
            }       
        }
        return $this->errors;
    }

    public function fileExist(array $fieldNames): array
    {
        foreach($fieldNames as $fieldName){
            if($this->propertyTable->exists($fieldName, $this->data[$fieldName]['name'], $this->propertyId)){
                $this->errors[$fieldName] = "Ce fichier '{$fieldName}' existe déjà !";
            }       
        }   
        return $this->errors;
    }

    public function fileSize(array $fieldNames): array
    {
        foreach($fieldNames as $fieldName){
            if($this->data[$fieldName]['size'] > 1000000){
                $this->errors[$fieldName] = "La taille du fichier '{$fieldName}' ne doit pas dépasser 1Mo !";
            }       
        }
        return $this->errors;
    }

    public function fileExtension(array $fieldNames): array
    {
        foreach($fieldNames as $fieldName){
            if($this->data[$fieldName] !== 'jpg'){
                $this->errors[$fieldName] = "L'extension du fichier '{$fieldName}' doit être au format 'jpg' !";
            }       
        }
        return $this->errors;
    }
 
}