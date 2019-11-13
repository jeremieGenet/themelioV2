<?php
namespace App\Models;

use \DateTime;
use App\Helpers\Text;

// Représente la table des bien
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
    
    /**************************************************** EN COURS DE DEV ************************************************************************** */
    //private $categories = []; // Tableau qui récup les catégories de l'annonce (LIAISON avec la table properties_category)



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
    public function setSlug(string $slug): ?string /////////////////////// J'ai laisser une erreur pour test le return $this, et le return $this->slug //////////////////
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
    // Retourne la description de l'annonce mais dans une limite de lettre (voir Text::excerpt())
    public function getDescription_excerpt(): ?string
    {
        if($this->description === null){
            return null;
        }
        // "nl2br" permet de respecter les sauts de lignes
        return nl2br(htmlentities(Text::excerpt($this->description, 120)));
    }
    // Retourne la description de l'annonce avec sauts de lignes et sécurisé par htmlentities()
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
        // retourne la date actuelle (au format "Y-m-d H-i-s", le format MySQL)
        return new DateTime($this->createdAt);
    }
    // Retourne la date de création au format FR ('d F Y')
    public function getCreatedAt_fr()
    {
        return $this->getCreatedAt()->format('d F Y');
    }
    // Modifie la date de création (retourne une chaîne de caractères)
    public function setCreatedAt(string $date): self
    {
        $this->createdAt = $date;
        return $this;
    }


    public function getPicture()
    {
        /*
        [
            "name" => "Comment-utiliser-le-dual-nback.pdf"
            "type" => "application/pdf"
            "tmp_name" => "D:\Code\xampp\tmp\phpC2CE.tmp"
            "error" => 0
            "size" => 822108
        ]
        */
        return $this->picture;
    }
    // Permet de récup le nom du fichier de l'image en lui retirant l'extension
    public function getPictureName(): ?string
    {
        return $this->getPicture()[0];
    }
    public function getPictureExt(): ?string
    {
        return pathinfo($this->getPicture()['name'], PATHINFO_EXTENSION); // Retourne l'extension du fichier
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
    
    
    
    /*
    // Récup la liste des catégories (d'un bien, property), et retourne une objet de type Category[]
     
    public function getCategories(): array
    {
        return $this->categories;
    }

    // Permet d'ajouter des catégories
    public function addCategories(Category $category): void
    {
        $this->categories[] = $category;
        $category->setPost($this); // On sauvegarde le post associé (pas utile pour notre blog)
    }
    */

}