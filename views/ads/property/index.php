<?php
// LISTE DES BIENS (accueil du SITE)

use App\Connection;
use App\Table\PropertyTable;

$title = "Annonces";
// Connexion à la bdd
$pdo = Connection::getPDO();

// On récup les résultats paginés (avec hydratation des biens (leur attribut "categories[]"))
// On donne les deux variables utiles au fonctionnement du script qui suit ("[$properties, $pagination]" sont les retours de la méthode findPaginated())
[$properties, $pagination] = (new PropertyTable($pdo))->findPaginated(); 

$link = $router->url('ads');
?>


<div class="container">

    <h1 class="text-dark text-center mb-4">Locations disponibles</h1>

    <!-- LISTE DES BIENS (8 par page) -->
    <div class="row">
        <?php foreach($properties as $property): ?>
        <div class="col-md-3 mt-2">
            <?php require 'card.php';?>
        </div>
        <?php endforeach ?>
    </div>
    <!-- PAGINATION -->
    <div class="d-flex justify-content-between my-4">
        <!-- LIEN PAGE PRECEDENTE -->
        <?= $pagination->previousLink($link) ?>
        <!-- LIEN PAGE SUIVANTE -->
        <?= $pagination->nextLink($link) ?>
    </div>

</div>


