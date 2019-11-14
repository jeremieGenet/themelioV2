<?php
/* 
    PAGE DE MODIFICATION D'UN BIEN (property)
*/
use App\Auth;
use App\Connection;
use App\Table\PropertyTable;
use App\Validators\PropertyValidator;

Auth::check();

$id = $params['id'];
$pdo = Connection::getPDO();
$propertyTable = new PropertyTable($pdo);
$property = $propertyTable->find($id); 
$success = false;
$errors = []; 

if(!empty($_POST)){
    $data = array_merge($_POST, $_FILES);
    $validate = new PropertyValidator($data, $propertyTable, $property->getId());

    $errors = $validate->fieldEmpty(['title', 'description']);
    $errors = $validate->fieldLength(3, 150, ['title']);
    $errors = $validate->fieldLength(5, 2000, ['description']);
    $errors = $validate->fieldExist(['title']);
    $errors = $validate->fileExist(['picture']);
    $errors = $validate->fileSize(['picture']);

    if(empty($errors)){
        $property->setTitle(htmlentities($_POST['title']));
        $property->setSlug($property->getSlugFormat()); /*** EN TEST */
        $property->setAddress(htmlentities($_POST['address']));
        $property->setPostalCode((int)$_POST['postalCode']);
        $property->setCity(htmlentities($_POST['city']));
        $property->setDescription(htmlentities($_POST['description']));
        $property->setSurface((int)$_POST['surface']);
        $property->setNbRoom((int)$_POST['nbRoom']);
        $property->setEnergeticClass(htmlentities($_POST['energeticClass']));
        $property->setPrice((int)$_POST['price']);
    
        if ($_FILES['picture']['error'] === 0 || $_FILES['picture']['error'] === 4) {
            $fileName = $_FILES['picture']['name'];
            $pathImages = 'assets/img/';

            if($fileName){
                $retour = copy(
                    $_FILES['picture']['tmp_name'],
                    $pathImages . $fileName
                );
                if($retour) {
                    if( ($property->getPicture() !== $fileName) && ($property->getPicture()) !== null){
                        unlink($pathImages . $property->getPicture());
                    }
                    $property->setPicture($fileName); 
                }
            }
            $propertyTable->update($property);
            $success = true;
        }
    }
}
?>

<div class="container">
    <h1 class="text-dark text-center mb-4">Edition du bien <?= htmlentities($property->getTitle()) ?></h1>
    <?php if($success): ?>
        <div class="alert alert-success">
            Le bien a été modifié !
        </div>
    <?php endif; ?>
    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            Le bien n'a pas pu être modifié, merci de corriger vos erreurs !
        </div>
    <?php endif; ?>
    <?php require ('_form.php') ?>
</div>