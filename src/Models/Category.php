<?php
namespace App\Models;

use App\Models\Property;

class Category{
    
    private $id;
    private $slug;
    private $name;

    private $property_id;

    private $property;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
    public function setSlug(string $slug): self 
    {
        $this->slug = $slug;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPropertyId(): ?int
    {
        return $this->property_id;
    }

    public function setProperty(Property $property){
        $this->property = $property;
    }

}