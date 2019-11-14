<?php
/*
    FORMULAIRE HTML (qui sert à la création et à l'édition d'un BIEN)
*/
use App\HTML\Form;
$form = new Form($property, $errors);
?>

<form action="" method="POST" enctype="multipart/form-data">

    <?= $form->input('title', 'Titre'); ?>
    <?= $form->input('address', 'Adresse'); ?>
    <?= $form->input('postalCode', 'Code Postal'); ?>
    <?= $form->input('city', 'Ville'); ?>
    <?= $form->textarea('description', 'Description'); ?>
    <?= $form->textarea('surface', 'Surface'); ?>
    <?= $form->textarea('nbRoom', 'Nombre de pièce'); ?>
    <?= $form->textarea('energeticClass', 'Catégorie Energétique'); ?>
    <?= $form->textarea('price', 'Montant du loyer mensuel'); ?>
    <?php if($property->getId() !== null) : ?>
        <div class="mh-100 mb-3" style="width: 350px; height: 200px; background-color: rgba(100,0,255,0.2);">
            <img src=" <?= "../../assets/img/" . $property->getPicture() ?>"
                class="rounded float-left img-thumbnail img-fluid"
                name="<?= $property->getPictureName() ?>"
                alt="<?= $property->getPicture() ?? "Pas d'illustration !" ?>"
            >
        </div>
    <?php endif ?>
    <?= $form->inputFile('picture', "Nom de l'image : ".$property->getPicture()); ?>

    <div class="d-flex justify-content-between mb-4">
        <button class="btn btn-success">
            <?php if($property->getId() !== null) : ?>
                Modifier
            <?php else: ?>
                Créer
            <?php endif ?>
        </button>
        <a href="<?= $router->url('admin_properties') ?>" class="btn btn-primary ml-auto">Retour &raquo;</a>
    </div>
    
</form>

