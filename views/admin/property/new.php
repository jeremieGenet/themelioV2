<?php
/* 
    PAGE DE CREATION D'UN BIEN (property)
*/
use App\Auth;
use App\Connection;
use App\Models\Property;
use App\Table\PropertyTable;
use App\Validators\PropertyValidator;

Auth::check();

$pdo = Connection::getPDO();
$propertyTable = new PropertyTable($pdo);
$errors = [];
$property = new Property(); 

if(!empty($_POST)){
    $data = array_merge($_POST, $_FILES);
    $validate = new PropertyValidator($data, $propertyTable, $property->getId());

    $errors = $validate->fieldEmpty(['title', 'description']);
    $errors = $validate->fieldFileEmpty(['picture']);
    $errors = $validate->fieldLength(3, 150, ['title']);
    $errors = $validate->fieldLength(5, 2000, ['description']);
    $errors = $validate->fieldExist(['title']);
    $errors = $validate->fileExist(['picture']);
    $errors = $validate->fileSize(['picture']);

    if(empty($errors)){
        $property->setTitle(htmlentities($_POST['title']));
        $property->setSlug($property->getSlugFormat()); /*************EN TEST*********************************/
        $property->setAddress(htmlentities($_POST['address']));
        $property->setPostalCode((int)$_POST['postalCode']);
        $property->setCity(htmlentities($_POST['city']));
        $property->setDescription(htmlentities($_POST['description']));
        $property->setSurface((int)$_POST['surface']);
        $property->setNbRoom((int)$_POST['nbRoom']);
        $property->setEnergeticClass(htmlentities($_POST['energeticClass']));
        $property->setPrice((int)$_POST['price']);

        if ($_FILES['picture']['error'] === 0) {
            $pathImages = 'assets/img/'; 
            $retour = copy(
                $_FILES['picture']['tmp_name'],
                $pathImages . $_FILES['picture']['name']
            );
            if($retour) {
                $property->setPicture($_FILES['picture']['name']); 
                header('Location: ' . $router->url('admin_properties', ['id' => $property->getId()]) . '?created=1');
            }
        }
        $propertyTable->insert($property);
        $success = true;
    }
}

?>
<div class="container">
    <h1 class="text-dark text-center mb-4">Création d'un Bien</h1>
    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            Le bien n'a pas pu être enregistré, merci de corriger vos erreurs
        </div>
    <?php endif; ?>
    <?php require ('_form.php') ?>
</div>