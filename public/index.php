<?php

use App\Router;

require'../vendor/autoload.php';


// Contante qui défini le timestamp avec les micro-secondes (pour le calcul du temps de génération d'une page dans le footer)  A RANGER*******************************
define('DEBUG_TIME', microtime(true));

// Utilisation de la librairie Whoops (aide à l'affichage et débug des erreurs)
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// Redirection générique pour toute url que posséde un param "?page=1" vers la même url sans ce param 
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

// ACCUEIL DU SITE
$router->get('/', 'accueil.php', 'home'); // Direction vers la page d'accueil du site

// ANNONCES
$router->get('/annonces', 'ads/property/index.php', 'ads'); // Direction vers la page qui liste les biens (propertyindex.php)
/******************************************** EN COURS DE DEV**************************************************************************************/
// $router->get('/annonces/category/[*:slug]-[i:id]', 'annonces/category/show.php', 'category'); // Direction vers la page des biens en fonction de la catégorie selectionnée
/**************************************************************************************************************************************************** */
$router->get('/annonces/[*:slug]-[i:id]', 'ads/property/show.php', 'ad'); // Direction vers la vue d'un bien (property/show.php)


// PAGE DE TEST (dans autre Module)
$router->get('/test', 'autreModule/inc/TEST.php', 'testalors'); // Direction vers une page de test


/******************************************** EN COURS DE DEV**************************************************************************************/
/*
// ADMINISTRATION
$router->get('/admin', 'admin/post/index.php', 'admin_posts'); // Direction vers l'administration des articles
$router->match('/admin/post/[i:id]', 'admin/post/edit.php', 'admin_post'); // Direction vers l'administration Modification d'un article ("match" pour pourvoir router en get et en post)
// suppression articles en "post" pour le rooting, afin que l'url ne fonctionne que si on post un formulaire (SECURITE POUR LES REDUCTION D'URL)
$router->post('/admin/post/[i:id]/delete', 'admin/post/delete.php', 'admin_post_delete'); // Direction vers l'administration Supprimer d'un article 
$router->match('/admin/post/new', 'admin/post/new.php', 'admin_post_new'); // Direction vers l'administration Création d'un articles (match pour y accéder en "get" et en "post")
*/
/**************************************************************************************************************************************************** */


$router->run();







