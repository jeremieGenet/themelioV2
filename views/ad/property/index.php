<?php

use App\Connection;
use App\Table\PropertyTable;

$title = "Locations disponibles";
$pdo = Connection::getPDO();
[$properties, $pagination] = (new PropertyTable($pdo))->findPaginated(); 
$link = $router->url('properties');
?>


<div class="container">
    <h1 class="text-dark text-center my-4">Nos locations disponibles</h1>
    <div class="row">
        <?php foreach($properties as $property): ?>
        <div class="col-md-3 mt-2">
            <?php require 'card.php';?>
        </div>
        <?php endforeach ?>
    </div>
    <div class="d-flex justify-content-between my-4">
        <?= $pagination->previousLink($link) ?>
        <?= $pagination->nextLink($link) ?>
    </div>

</div>


