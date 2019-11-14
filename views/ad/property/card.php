<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= htmlentities($property->getTitle()) ?></h5>
        <p class="text-muted"><?= $property->getCreatedAt_fr() ?></p>
        <?php foreach($property->getCategories() as $category): ?>
            <div class="text-center">
                <a href="<?= $router->url('category', ['slug' => $category->getSlug(), 'id' => $category->getId()]) ?>">
                    <?= $category->getName() ?>
                </a>
            </div>
        <?php endforeach ?>
        <div class="text-center mt-3">
            <a href="<?=  $router->url('property', ['slug' => $property->getSlug(), 'id' => $property->getId()]) ?>">
                <img src="<?= "assets/img/" . $property->getPicture() ?>" class="img-fluid rounded" alt="">
            </a>
        </div>
        <p class="mt-3"><?= $property->getDescription_excerpt() ?></p>
        <p>
            <a href="<?=  $router->url('property', ['slug' => $property->getSlug(), 'id' => $property->getId()]) ?>" class="btn btn-primary">
                Voir plus
            </a>
        </p>
    </div>
</div>