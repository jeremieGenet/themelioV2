roperty<?php
// PAGE D'AFFICHAGE D'UN BIEN (property)

use App\Connection;
use App\Models\{Property, Category};
use App\Table\PropertyTable;

$id = (int)$params['id'];
$slug = $params['slug'];

// Connextion à la bdd
$pdo = Connection::getPDO();
// Récup du bien (via son id passé en param dans l'url)
$property = (new PropertyTable($pdo))->find($id);

// Si le slug du bien est différent de celui de l'url ($slug défini plus haut grâce à notre router) alors on redirige vers le slug et l'id du bien original
if($property->getSlug() !== $slug){
    $url = $router->url('ads', ['slug' => $property->getSlug(), 'id' => $id]);
    http_response_code(301); // Notification de redirection d'url permanente
    header('Location: ' .$url); // Redirection vers l'url du bien via son slug et son id original (ceux dans la bdd)
}

/********************************************* EN COURS DE DEV ******************************************************************** */
/*
// Récup des catégories du bien
$query = $pdo->prepare('
SELECT blog_category.id, category.slug, category.name
FROM property_category pc 
JOIN blog_category ON pc.category_id = category.id
WHERE pc.property_id = :id');
$query->execute(['id' => $property->getId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class); // On change le mode de recherche (Fetch)

$categories = $query->fetchAll();
//dd($categories); // On récup sous forme de tableau l'ensemble des catégories (avec id, slug, et name) du bien
*/
/********************************************************************************************************************************* */


?>

<!-- AFFICHAGE D'UN BIEN (sur toute la page, après sélection de celui-ci) -->
<div class="container">
    <div class="card">
        <div class="card-body">
            <!-- NOM -->
            <h2 class="card-title text-center"><?= htmlentities($property->getTitle()) ?></h2>
            <!-- DATE -->
            <p class="text-muted text-center"><?= $property->getCreatedAt_fr() ?></p>
            <!-- Lien vers les CATEGORIES -->
            <!---------------------------------------------------------------En cours de dev------------------------------------------------------------------>
            <?php //foreach($categories as $category): ?>
                <div class="text-center">
                    <a href="<?php //$router->url('category', ['slug' => $category->getSlug(), 'id' => $category->getId()]) ?>"><?php // $category->getName() ?></a>
                    EN COUR DE DEV
                </div>
            <?php //endforeach ?>
            
            <!-- IMAGE -->
            <div class="text-center mt-3">
                <img src="<?= $property->getPicture() ?>" class="img-fluid rounded" alt="">
            </div>
            <!-- CONTENU -->
            <p class="mt-3"><?= $property->getFormatedDescription() ?></p>
            <!-- LIEN (RETOUR à l'accueil des annonces) -->
            <p>
                <a href="<?=  $router->url('ads') ?>" class="btn btn-info">
                    Retour
                </a>
            </p>
        </div>
    </div>
</div>