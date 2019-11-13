<?php
namespace App\Table;

use PDO;
use App\Table\Exception\NotFoundException;
//use App\Table\Exception\NotFoundException;

// Cette classe sert de modèle (elle n'a pas vocation à être instanciée) d'ou le "abstract" devant
abstract class Table{

    protected $pdo;
    protected $table = null; // table de la bdd
    protected $class = null; // class utilisée pour le mode de récup des données (fetch)

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Récup un item (de la bdd) via son id
    public function find(int $id)
    {
        // Récup de l'item (via son id passé en param dans l'url)
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class); // On change le mode de recherche (Fetch) et on signifie que l'on va utiliser par classe
        $item = $query->fetch();
        // Condition si l'item' n'existe pas
        if($item === false){
            throw new NotFoundException($this->table, $id);
        }
        // Retourne un item
        return $item ;
    }

    // Récup l'ensembles des items de la table
    public function findAll()
    {
        $query = $this->pdo->query('
            SELECT * FROM ' . $this->table
        );
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->class); // On change le mode de recherche (Fetch) et on signifie que l'on va utiliser par classe
        $items = $query->fetchAll();
        return $items;
    }

    /**
     * Vérif si une valeur existe dans la table de la bdd (utilisé dans le constructeur de la classe PropertyValidator)
     * Signature : $propertyTable->exists($field, $value); 
     *
     * @param string $field Champs à rechercher
     * @param mixed $value Valeur du champ
     * @return boolean
     */
    public function exists(string $field, $value, ?int $except = null): bool
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?";
        // Si "$except" est différent de null (donc il est défini lors de l'utilisation de la méthode exists()) alors...
        if($except !== null){
            $sql .= " AND id != $except"; // On ajoute à notre requête que la recherche s'applique uniquement sur les id différents de celui passé en paramètre ($except)
        }
        $query = $this->pdo->prepare($sql);
        $query->execute([$value]);
        return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0; // si le nb d'enregistrement est supérieur à 0 (c'est qu'il y a bien un enregistrement) retourne true
    }

}