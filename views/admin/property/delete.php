<?php
/*
    PAGE DE SUPPRESSION D'UN BIEN (property), TRAITEMENT UNIQUEMENT
*/

use App\Auth;
use App\Connection;
use App\Table\PropertyTable;


Auth::check();

$pdo = Connection::getPDO();
$table = new PropertyTable($pdo);
$property = $table->find($params['id']);
$table->delete($property, $params['id']);

header('Location: ' . $router->url('admin_properties') . '?delete=1'); 

?>
