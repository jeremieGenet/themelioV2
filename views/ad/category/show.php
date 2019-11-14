<?php
use App\Connection;
use App\Table\PropertyTable;
use App\Table\CategoryTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();

$category = (new CategoryTable($pdo))->find($id);

if($category->getSlug() !== $slug){
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' .$url);
}


$title = $category->getName();

[$properties, $pagination] = (new PropertyTable($pdo))->findPaginatedForCategory($id); 

$link = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);

?>
<div class="container">
    <h1 class="text-dark text-center mb-4">Biens de la catégorie: <strong><?= htmlentities($title) ?></strong></h1>

    <div class="row">
        <?php foreach($properties as $property): ?>
        <div class="col-md-3 mt-2">
            <?php require dirname(__DIR__) . '/property/card.php';?>
        </div>
        <?php endforeach ?>
    </div>

    <div class="d-flex justify-content-between my-4">
        <?= $pagination->previousLink($link) ?>
        <?= $pagination->nextLink($link) ?>
    </div>
</div>
