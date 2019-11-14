<?php
namespace App\Table;

use App\Models\Category;
use PDO;

class CategoryTable extends Table{

    protected $table = "category";
    protected $class = Category::class;


    /**
     * Rempli l'attribut "categories[]" (par jointure) des properties
     *
     * @param App\Models\Property[] $properties
     * @return void
     */
    public function hydrateProperties(array $properties): void
    {
        $propertiesById = [];
        foreach($properties as $property){
            $propertiesById[$property->getId()] = $property;
        }

        $categories = $this->pdo->query(
            'SELECT bc.*, pc.property_id
            FROM property_category pc 
            JOIN category bc ON bc.id = pc.category_id 
            WHERE pc.property_id IN (' . implode(',', array_keys($propertiesById)) . ')' 
        )->fetchAll(PDO::FETCH_CLASS, Category::class);
        foreach($categories as $category){
            $propertiesById[$category->getPropertyId()]->addCategories($category);
        }
    }
}