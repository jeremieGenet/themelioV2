<?php
use App\Router;

require'../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

if(isset($_GET['page']) && $_GET['page'] === '1'){
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $get = $_GET;
    unset($get['page']);
    $query = http_build_query($get);
    if(!empty($query)){
        $uri = $uri . '?' . $query;
    }
    http_response_code(301);
    header('Location: ' . $uri);
    exit();
}
$router = new Router(dirname(__DIR__) . '/views');

/*
    ACCUEIL DU SITE
*/
$router->get('/', 'home.php', 'home');
/*
    ANNONCES
*/
$router->get('/annonce', 'ad/property/index.php', 'properties');
$router->get('/annonce/categorie/[*:slug]-[i:id]', 'ad/category/show.php', 'category');
$router->get('/annonce/[*:slug]-[i:id]', 'ad/property/show.php', 'property');
/*
    PAGE DE TEST
*/
$router->get('/autre-module', 'autreModule/TEST.php', 'test');
/*
    ADMINISTRATION
*/
$router->get('/admin', 'admin/property/index.php', 'admin_properties');
$router->match('/admin/annonce/[i:id]', 'admin/property/edit.php', 'admin_property');
$router->post('/admin/annonce/[i:id]/delete', 'admin/property/delete.php', 'admin_property_delete');
$router->match('/admin/annonce/new', 'admin/property/new.php', 'admin_property_new');

$router->run();







