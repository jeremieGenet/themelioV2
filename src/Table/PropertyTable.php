<?php
namespace App\Table;

use App\PaginatedQuery;
use App\Models\Property;


class PropertyTable extends Table{

    protected $table = "property";
    protected $class = Property::class;

    /*
        METHODES DANS LE MODEL Table.php :

        function find()  
        function findAll()
        function exists()  Vérif si un item existe
    */
    public function update(Property $property): void
    {
        $query = $this->pdo->prepare("
            UPDATE {$this->table} SET 
            title = :title, 
            slug = :slug, 
            address = :address, 
            postalCode = :postalCode,
            city = :city,
            description = :description,
            surface = :surface,
            nbRoom = :nbRoom,
            energeticClass = :energeticClass,
            price = :price,
            picture = :picture, 
            createdAt = :createdAt
            WHERE id = :id"); 
        $result = $query->execute([
            'id' => $property->getId(),
            'slug' => $property->getSlug(),
            'title' => $property->getTitle(),
            'address' => $property->getAddress(),
            'postalCode' => $property->getPostalCode(),
            'city' => $property->getCity(),
            'description' => $property->getDescription(),
            'surface' => $property->getSurface(),
            'nbRoom' => $property->getNbRoom(),
            'energeticClass' => $property->getEnergeticClass(),
            'price' => $property->getPrice(),
            'createdAt' => $property->getCreatedAt()->format('Y-m-d H:i:s'),
            'picture' => $property->getPicture()
        ]); 
        
        if($result === false){
            throw new \Exception("Impossible de modifier l'enregistrement $property->getId() dans la table {$this->table}");
        }
    }

    public function insert(Property $property)
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET 

            title = :title, 
            slug = :slug,
            address = :address, 
            postalCode = :postalCode,
            city = :city,
            description = :description,
            surface = :surface,
            nbRoom = :nbRoom,
            energeticClass = :energeticClass,
            price = :price,
            picture = :picture, 
            createdAt = :createdAt
            
        "); 
        $result = $query->execute([ 
            
            'title' => $property->getTitle(),
            'slug' => $property->getSlug(),
            'address' => $property->getAddress(),
            'postalCode' => $property->getPostalCode(),
            'city' => $property->getCity(),
            'description' => $property->getDescription(),
            'surface' => $property->getSurface(),
            'nbRoom' => $property->getNbRoom(),
            'energeticClass' => $property->getEnergeticClass(),
            'price' => $property->getPrice(),
            'picture' => $property->getPicture(),
            'createdAt' => $property->getCreatedAt()->format('Y-m-d H:i:s')
            
        ]);
        
        if($result === false){
            throw new \Exception("Impossible de créer le bien dans la table {$this->table}");
        }
        $property->setId((int)$this->pdo->lastInsertId()); 
        
    }

    public function delete(Property $property, int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");

        $result = $query->execute([$id]); 
        
        if($property->getPicture() !== null){
            unlink('assets/img/' . $property->getPicture());
        }
        
        if($result === false){
            throw new \Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }
    }

    public function findPaginated()
    {
        /**
         * Instanciation de notre Classe PaginatedQuery()
         * 
         * Param 1 : Requête qui permet de récup les items (biens ici)
         * Param 2 : Requête qui compte les items
         * Param 3 : connection à la bdd
         * Param 4 : le nb d'élément par page (pour la paginationn), 8 par défaut
         */
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM {$this->table} ORDER BY createdAt DESC",
            "SELECT COUNT(id) FROM {$this->table}",
            $this->pdo
        );
        $properties = $paginatedQuery->getItems(Property::class);
        (new CategoryTable($this->pdo))->hydrateProperties($properties);
        return [$properties, $paginatedQuery];
    }

    
    public function findPaginatedForCategory(int $categoryId)
    {
        /**
         * Instanciation de notre Classe PaginatedQuery()
         * 
         * Param 1 : Requête qui permet de récup les items (catégories ici)
         * Param 2 : Requête qui compte les items
         * Param 3 et 4 optionels (inutiles ici)
         */
        $paginatedQuery = new PaginatedQuery(
            "SELECT * 
            FROM {$this->table} bp
            JOIN property_category bpc ON bpc.property_id = bp.id
            WHERE bpc.category_id = {$categoryId}
            ORDER BY createdAt DESC",
            "SELECT COUNT(category_id) FROM property_category WHERE category_id = {$categoryId}"
        );
        $properties = $paginatedQuery->getItems(Property::class);
        (new CategoryTable($this->pdo))->hydrateProperties($properties);
        return [$properties, $paginatedQuery];
    }


}