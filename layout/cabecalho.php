<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Menu Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color:rgba(56, 90, 139, 1);
    }

    .botao {
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .botao:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(35, 35, 43, 0.57);
    }

    .caixa_de_sites {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 100%;
    }

    #centro-menu {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        gap: 50px;
        flex-wrap: wrap;
        justify-content: space-around;
        max-width: 900px;
        width: 80%;
        min-width: 240px;
        flex-direction: row;
    }

    .card {
        background-color: rgba(232, 241, 255, 1);
        border: none;
        border-radius: 12px;
        padding: 2rem;
        min-width: 220px;
        min-height: 200px;
        box-shadow: 0 4px 15px rgba(12, 8, 8, 0.3);
    }

    .card h4 {
        margin: 0;
        font-size: 1.4rem;
        color: #333;
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
                </ul>
                <?php if (($_SESSION['id'] == null)) { ?>
                    <div class="d-flex gap-2">
                        <a class="btn btn-primary" style="border: 1px solid white;" href="<?= $front ?>/login.php">Login</a>
                        <a class="btn btn-success" style="border: 1px solid white;" href="<?= $front ?>/cadastro.php">Cadastro</a>
                    </div>
                <?php } else { ?>
                    <div class="d-flex gap-2">
                        <h4 class="text-white"><?php echo $_SESSION['nome'] ?></h4>
                        <a class="btn btn-primary" style="border: 1px solid white;" href="<?= $back ?>/deslogar.php">Sair</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </nav>
