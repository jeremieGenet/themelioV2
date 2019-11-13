<?php
namespace App\Table;

use App\PaginatedQuery;
use App\Models\Property;


// Gère les requêtes de la table "property" (table des biens)
class PropertyTable extends Table{

    // Ces 2 propriétés permettent de donner les infos nécessaires à la méthode find() de la class Table.php
    protected $table = "property"; // Table de la bdd (qui permet de trouver un article, voir class Table.php)
    protected $class = Property::class; // Class qui défini le mode de recherche dans la bdd (voir class Table.php)

    /*
        METHODES DANS LE MODEL Table.php :

        function find()  
        function findAll()
        function exists()  Vérif si un item existe
    */

    
    // Modifie property (un bien) dans la bdd
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
        $result = $query->execute([ // $result vaudra "true" ou "false" en fonction de la réussite ou non de la suppression de l'item
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
            'createdAt' => $property->getCreatedAt()->format('Y-m-d H:i:s'), // Formatage au format admit par MySQL
            'picture' => $property->getPicture()
        ]); 
        // Si la Modification n'a pas fonctionnée alors...
        if($result === false){
            throw new \Exception("Impossible de modifier l'enregistrement $property->getId() dans la table {$this->table}");
        }
    }

    // Insère property (un bien) dans la bdd
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
        // $result vaudra "true" ou "false" en fonction de la réussite ou non de la suppression du bien
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
            'createdAt' => $property->getCreatedAt()->format('Y-m-d H:i:s'), // Formatage au format admit par MySQL
            'picture' => $property->getPicture()
        ]);
        // Si la création du bien n'a pas fonctionnée alors...
        if($result === false){
            throw new \Exception("Impossible de créer le bien dans la table {$this->table}");
        }
        // On récup l'id du bien (pour l'utiliser comme param de redirection)
        $property->setId((int)$this->pdo->lastInsertId()); 
        
    }

    // Supprime un bien en fonction de son id (renvoie une exception si cela n'a pas fonctionné)
    public function delete(Property $property, int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");

        // $result vaudra "true" ou "false" en fonction de la réussite ou non de la suppression de l'item (permet de jetter une exception plus bas)
        $result = $query->execute([$id]); 
        
        // SUPPRESSION de l'image dans le dossier de stockage (si il y en a une)
        if($property->getPicture()){
            //dd($property->getPicture());
            unlink('assets/img/' . $property->getPicture());
        }
        
        // Si la suppression n'a pas fonctionnée alors...
        if($result === false){
            throw new \Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }
    }

    // Récup les résultats paginés des biens (utilisé pour l'affichage de l'ensemble des biens dans property/index.php)
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
        // Récup des biens (en param la classe sur laquelle on veut récup les items)
        $properties = $paginatedQuery->getItems(Property::class);


        /**************************************************** EN COURS DE DEV ************************************************************************** */
        /*
        // Rempli l'attribut "categories[]" (par jointure) des biens via la méthode "hydrateProperties()" de la classe CategoryTable
        (new CategoryTable($this->pdo))->hydrateProperties($properties);
        // Retourne la liste des biens et la liste des biens paginés
        */


        return [$properties, $paginatedQuery];
    }

    /**************************************************** EN COURS DE DEV ************************************************************************** */
    /*
    // Récup les résultats paginés des biens (utilisé pour l'affichage de l'ensemble des biens qui appartiennent à la catégorie selectionnée dans category/show.php)
    public function findPaginatedForCategory(int $categoryId)
    {

        /**
         * Instanciation de notre Classe PaginatedQuery()
         * 
         * Param 1 : Requête qui permet de récup les items (catégories ici)
         * Param 2 : Requête qui compte les items
         * Param 3 et 4 optionels (inutiles ici)
         */

        /*

        $paginatedQuery = new PaginatedQuery(
            "SELECT * 
            FROM {$this->table} bp
            JOIN property_category bpc ON bpc.property_id = bp.id
            WHERE bpc.category_id = {$categoryId}
            ORDER BY created_at DESC",
            "SELECT COUNT(category_id) FROM property_category WHERE category_id = {$categoryId}"
        );
        // Récup des biens (en param la classe sur laquelle on veut récup les biens)
        $properties = $paginatedQuery->getItems(Property::class);
        // Rempli l'attribut "categories[]" (par jointure) des biens via la méthode "hydrateProperties()" de la classe CategoryTable
        (new CategoryTable($this->pdo))->hydrateProperties($properties);
        // Retourne la liste des biens et la liste des biens paginés
        return [$properties, $paginatedQuery];

    }

    **********************************************************************************************************************/


}