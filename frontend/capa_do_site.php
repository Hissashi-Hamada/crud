    <?php
    include '../backend/config.php';
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo $front ?>/capa_do_site.php">Menu</a>
        
        <div class="container mt-4">
            <a class="btn btn-primary me-2" style="border: 1px solid white;" href="<?php echo $front ?>/login.php">Login</a>
            <a class="btn btn-success"  style="border: 1px solid white;"  href="<?php echo $front ?>/cadastro.php">Cadastro</a>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link active text-white" href="#">Menu</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#">Link</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">Mostrar mais</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Ação</a></li>
                <li><a class="dropdown-item" href="#">Outra Ação</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Algo a Mais</a></li>
                </ul>
            </li>
            </ul>
        </div>
        </div>
    </nav>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
