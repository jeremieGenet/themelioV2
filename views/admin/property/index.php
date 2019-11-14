<?php
/*
    PAGE ADMINISTRATION DES BIENS (Liens vers création / modification / suppression)
*/
use App\Auth;
use App\Connection;
use App\Table\PropertyTable;

Auth::check();

$title = "Administration";
$pdo = Connection::getPDO();
$link = $router->url('admin_properties');

[$properties, $pagination] = (new PropertyTable($pdo))->findPaginated();
?>

<div class="container">

    <h2 class="text-center mb-4">Administration des biens</h2>

    <?php if(isset($_GET['delete'])): ?>
        <div class="alert alert-success">
            Le bien aété supprimé !
        </div>
    <?php endif ?>
    <?php if(isset($_GET['created'])): ?>
        <div class="alert alert-success">
            Le bien a été créé !
        </div>
    <?php endif; ?>
    <table class="table">
        <thead class="text-dark">
            <th>Id</th>
            <th>Titre</th>
            <th>
                Aperçu
            </th>
            <th>
                <a href="<?= $router->url('admin_property_new') ?>" class="btn btn-light">Créer un Bien</a>
            </th>
        </thead>
        <tbody>
            <?php foreach($properties as $property): ?>
            <tr>
                 <td>
                    <?= htmlentities($property->getId()) ?>
                </td>
                <td>
                    <a href="<?= $router->url('admin_property', ['id' => $property->getId()]) ?>">
                        <?= htmlentities($property->getTitle()) ?>
                    </a>
                </td>
                <td>
                    <img src="<?= "../../assets/img/" . $property->getPicture() ?>"
                        class="rounded float-left img-thumbnail img-fluid"
                        style="width: 120px; height: 70px; background-color: rgba(100,0,255,0.2);"
                        name="<?= $property->getPictureName() ?>"
                        alt="<?= $property->getPicture() ?? "Pas d'illustration !" ?>"
                    >
                </td>
                <td>
                    <a href="<?= $router->url('admin_property', ['id' => $property->getId()]) ?>" class="btn btn-info">
                        Editer
                    </a>
                    <form action="<?= $router->url('admin_property_delete', ['id' => $property->getId()]) ?>" method="POST" style="display:inline"
                        onsubmit="return confirm('Voulez-vous vraiment effectuer la suppression ?')">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-between my-4">
        <?= $pagination->previousLink($link) ?>
        <?= $pagination->nextLink($link) ?>
    </div>

</div>