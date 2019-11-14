<?php
namespace App\Models;

use \DateTime;
use App\Helpers\Text;

class Property{

    private $id;
    private $slug;
    private $title;
    private $address;
    private $postalCode;
    private $city;
    private $description;
    private $surface;
    private $nbRoom;
    private $energeticClass;
    private $price;
    private $createdAt;
    private $picture;
    
    private $categories = [];



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
    public function getSlugFormat(): ?string
    {
        $title = explode(' ', $this->title);
        $slugTitle = implode("-", $title);
        return strtolower($slugTitle);

    }
    public function setSlug(string $slug): ?string
    {
        $this->slug = $slug;
        return $this->slug;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function setTitle(string $title): self 
    {
        $this->title = $title;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }
    public function setAddress(string $address): self 
    {
        $this->address = $address;
        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;

    }
    public function setPostalCode(int $postalCode): self 
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }
    public function setCity(string $city): self 
    {
        $this->city = $city;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getDescription_excerpt(): ?string
    {
        if($this->description === null){
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->description, 120)));
    }
    public function getFormatedDescription(): ?string
    {
        return nl2br(htmlentities($this->description));
    }
    public function setDescription(string $description): self 
    {
        $this->description = $description;
        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }
    public function setSurface(int $surface): self 
    {
        $this->surface = $surface;
        return $this;
    }

    public function getNbRoom(): ?int
    {
        return $this->nbRoom;
    }
    public function setNbRoom(int $nbRoom): self 
    {
        $this->nbRoom = $nbRoom;
        return $this;
    }

    public function getEnergeticClass(): ?string
    {
        return $this->energeticClass;
    }
    public function setEnergeticClass(string $energeticClass): self 
    {
        $this->energeticClass = $energeticClass;
        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }
    public function setPrice(int $price): self 
    {
        $this->price = $price;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->createdAt);
    }
    public function getCreatedAt_fr()
    {
        return $this->getCreatedAt()->format('d F Y');
    }
    public function setCreatedAt(string $date): self
    {
        $this->createdAt = $date;
        return $this;
    }


    public function getPicture()
    {
        return $this->picture;
    }
    public function getPictureName(): ?string
    {
        return $this->getPicture()[0];
    }
    public function getPictureExt(): ?string
    {
        return pathinfo($this->getPicture()['name'], PATHINFO_EXTENSION);
    }
    public function getPictureSize(): ?int
    {
        return $this->getPicture()['size'];
    }
    public function setPicture($picture): self
    {
        $this->picture = $picture;
        return $this;
    }
    
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function addCategories(Category $category): void
    {
        $this->categories[] = $category;
        $category->setProperty($this);
    }
    

}