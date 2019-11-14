<!DOCTYPE html>
<html lang="fr" class="h-100"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>
            <?= $title ?? 'Themelio.fr' ?> 
        </title>
        <link rel="stylesheet" href="../../css/bootstrap_Lumen.css">
        <link rel="stylesheet" href="../../css/app.css">
    </head>
    <body class="d-flex flex-column h-100"> 
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <a class="navbar-brand" href="<?=  $router->url('home') ?>">Themelio.fr</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?=  $router->url('properties') ?>">LOCATIONS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=  $router->url('test') ?>">Autre Module</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a href="#" class="nav-link bg-primary my-2">
                                Déconnexion
                            </a> 
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="container-fluid my-4">
            <?= $content ?>
        </div>
        <footer class="py-5 text-center mt-auto bg-primary"> 
            <p>© 1980-2025, Themelio.fr. Proudly created with by my fingers</p>
            <p>Page générée en <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?>ms</p> 
        </footer>
        <script src="../../js/jquery.min.js"></script>
        <script src="../../js/popper.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
        <script src="../../js/custom.js"></script>
    </body>
</html>