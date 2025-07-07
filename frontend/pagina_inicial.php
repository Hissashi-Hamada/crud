<?php
include '../backend/config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Menu Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    .botao {
        cursor: pointer;
    }

    .caixa_de_sites {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: row;
        height: 100%;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $front ?>/pagina_inicial.php">Menu</a>

            <!-- Botão para toggle do menu mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- <li class="nav-item"><a class="nav-link active text-white" aria-current="page" href="#">Menu</a>
                    </li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Link</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Mostrar mais</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Ação</a></li>
                            <li><a class="dropdown-item" href="#">Outra Ação</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Algo a Mais</a></li>
                        </ul>
                    </li> -->
                </ul>

                <div class="d-flex gap-2">
                    <a class="btn btn-primary" style="border: 1px solid white;" href="<?= $front ?>/login.php">Login</a>
                    <a class="btn btn-success" style="border: 1px solid white;"
                        href="<?= $front ?>/cadastro.php">Cadastro</a>
                </div>
            </div>
        </div>
    </nav>

    <section aria-label="Painel de opções principais" class="py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card p-3 h-100 botao" style="min-height: 200px;" onclick="produtos()">
                        <div class="caixa_de_sites">
                            <h4>Produtos</h4>
                        </div>
                    </div>
                </div>


                <!-- <div class="col-12 col-sm-6 col-md-4 col-lg-3"> -->
                    <!-- <div class="card p-3 h-100 botao" style="min-height: 200px;" onclick="estoque()"> -->
                        <!-- <div class="caixa_de_sites"> -->
                            <!-- <h4>Estoque</h4> -->
                        <!-- </div> -->
                    <!-- </div> -->
                <!-- </div> -->
<!--  -->
<!--  -->
                <!-- <div class="col-12 col-sm-6 col-md-4 col-lg-3"> -->
                    <!-- <div class="card p-3 h-100 botao" style="min-height: 200px;" onclick="clientes()"> -->
                        <!-- <div class="caixa_de_sites"> -->
                            <!-- <h4>Clientes</h4> -->
                        <!-- </div> -->
                    <!-- </div> -->
                <!-- </div> -->
<!--  -->
<!--  -->
                <!-- <div class="col-12 col-sm-6 col-md-4 col-lg-3"> -->
                    <!-- <div class="card p-3 h-100 botao" style="min-height: 200px;" onclick="fornecedores()"> -->
                        <!-- <div class="caixa_de_sites"> -->
                            <!-- <h4>Fornecedores</h4> -->
                        <!-- </div> -->
                    <!-- </div> -->
                <!-- </div> -->
            <!-- </div> -->
        <!-- </div> -->
    </section>

    <script>
    function produtos() {
        window.location.href = "<?= $front ?>/aba_produto.php";
    }

    function estoque() {
        window.location.href = "<?= $front ?>/aba_estoque.php";
    }

    function clientes() {
        window.location.href = "<?= $front ?>/aba_clientes.php";
    }

    function fornecedores() {
        window.location.href = "<?= $front ?>/aba_fornecedores.php";
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>