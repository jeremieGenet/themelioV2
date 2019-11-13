<!-- HTML D'UN BIEN (Property) -->

<div class="card">
    <div class="card-body">
        <!-- NOM -->
        <h5 class="card-title"><?= htmlentities($property->getTitle()) ?></h5>
        <!-- DATE -->
        <p class="text-muted"><?= $property->getCreatedAt_fr() ?></p>
        <!-- LISTE DES CATEGORIES (on boucle sur les catégories du bien en question) -->
        <?php //foreach($property->getCategories() as $category): ?>
            <div class="text-center">
                <a href="<?php // $router->url('category', ['slug' => $category->getSlug(), 'id' => $category->getId()]) ?>">
                    <?php // $category->getName() ?>
                    EN DEVELOPPEMENT
                </a>
            </div>
        <?php //endforeach ?>
        <!-- IMAGE -->
        <div class="text-center mt-3">
            <!-- Lien vers le bien sélectionné -->
            <a href="<?=  $router->url('ad', ['slug' => $property->getSlug(), 'id' => $property->getId()]) ?>">
                <img src="<?= $property->getPicture() ?>" class="img-fluid rounded" alt="">
            </a>
        </div>
        <!-- CONTENU -->
        <p class="mt-3"><?= $property->getDescription_excerpt() ?></p>
        <!-- LIEN (Voir plus) -->
        <p>
            <a href="<?=  $router->url('ads', ['slug' => $property->getSlug(), 'id' => $property->getId()]) ?>" class="btn btn-info">
                Voir plus
            </a>
        </p>
    </div>
</div>