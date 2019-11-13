<!DOCTYPE html>
<html lang="fr" class="h-100"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>
            <?= $title ?? 'themelio.fr' ?> 
        </title>

        <!-- Style Bootstrap -->
        <link rel="stylesheet" href="../../css/bootstrap_Cyborg.css">

        <!-- Mon style Css-->
        <link rel="stylesheet" href="../../css/app.css">

    </head>


    <body class="d-flex flex-column h-100"> 

        <!-- HEADER DU SITE -->
        <header>
            
            <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
                <a class="navbar-brand" href="<?=  $router->url('home') ?>">Mon Site</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <!--<a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>-->
                            <a class="nav-link" href="<?=  $router->url('home') ?>">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <!--<a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>-->
                            <a class="nav-link" href="<?=  $router->url('ads') ?>">Locations</a>
                        </li>
                        <li class="nav-item">
                            <!--<a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>-->
                            <a class="nav-link" href="<?=  $router->url('testalors') ?>">TEST</a>
                        </li>
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a href="#" class="nav-link bg-secondary my-2">
                                Déconnexion
                            </a> 
                        </li>

                    </ul>
                </div>
            </nav>
            
        </header>


        <!-- CONTENU DU SITE -->
        <div class="container-fluid my-4">

            <?= $content ?>

        </div> <!-- Fin de div container -->    

        <!-- FOOTER -->
        <footer class="py-5 text-center mt-auto bg-light"> 
            <p>© 1820-2025, Themelio.fr . Proudly created by my fingers</p>
            <!--Calcul du délai d'affichage de la page (DEBUG_TIME est un timestamp en mili-secondes) -->
            <p>Page générée en <strong><?= round(1000 * (microtime(true) - DEBUG_TIME)) ?></strong> ms</p> 
        </footer>

        <!-- Les 3 scripts suivants servent au fonctionnement de bootstrap -->
        <script src="../../js/jquery.min.js"></script>
        <script src="../../js/popper.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
        
        <script src="../../js/custom.js"></script>

    </body>

</html>