<?php
use App\Connection;
use App\Models\{Property, Category};
use App\Table\PropertyTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();
$property = (new PropertyTable($pdo))->find($id);

if($property->getSlug() !== $slug){
    $url = $router->url('property', ['slug' => $property->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' .$url);
}

$query = $pdo->prepare('
SELECT category.id, category.slug, category.name
FROM property_category pc 
JOIN category ON pc.category_id = category.id
WHERE pc.property_id = :id');
$query->execute(['id' => $property->getId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category[] */
$categories = $query->fetchAll();

?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center"><?= htmlentities($property->getTitle()) ?></h2>
            <p class="text-muted text-center"><?= $property->getCreatedAt_fr() ?></p>
            <?php foreach($categories as $category): ?>
                <div class="text-center">
                    <a href="<?= $router->url('category', ['slug' => $category->getSlug(), 'id' => $category->getId()]) ?>">
                        <?= $category->getName() ?>
                    </a>
                </div>
            <?php endforeach ?>
            <div class="text-center mt-3">
                <img src="<?= '../assets/img/'.$property->getPicture() ?>" class="img-fluid rounded" alt="">
            </div>
            <p class="mt-3"><?= $property->getFormatedDescription() ?></p>
            <p>
                <a href="<?=  $router->url('properties') ?>" class="btn btn-info">
                    Retour
                </a>
            </p>
        </div>
    </div>
</div>