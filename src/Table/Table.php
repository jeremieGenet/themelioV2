<?php
namespace App\Table;

use PDO;
use App\Table\Exception\NotFoundException;

abstract class Table{

    protected $pdo;
    protected $table = null;
    protected $class = null;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(int $id)
    {
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class); 
        $item = $query->fetch();
        if($item === false){
            throw new NotFoundException($this->table, $id);
        }
        return $item ;
    }

    public function findAll()
    {
        $query = $this->pdo->query('
            SELECT * FROM ' . $this->table
        );
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->class);
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
        if($except !== null){
            $sql .= " AND id != $except";
        }
        $query = $this->pdo->prepare($sql);
        $query->execute([$value]);
        return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
    }

}