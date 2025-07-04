<?php
include '../backend/config.php';

$sql = "SELECT * FROM produtos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($produtos)

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $public ?> /css/aba_produtos.css ">

</head>

<body>

    <header>

        <nav class="navbar navbar-expand-lg navbar-danger bg-danger">
            <div class="container-fluid">
                <a class="navbar-brand text-white" href="<?php echo $front ?>/capa_do_site.php">Menu</a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active text-white" href="#">Menu</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="#">Link</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">Mostrar
                                mais</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Ação</a></li>
                                <li><a class="dropdown-item" href="#">Outra Ação</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Algo a Mais</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="container mt-4" style="display: flex; align-content: center;
                                        flex-wrap: wrap;
                                        align-items: center;
                                        justify-content: flex-end;">
                    <a class="btn btn-primary me-2" style="border: 1px solid white;"
                        href="<?php echo $front ?>/login.php">Login</a>
                    <a class="btn btn-success" style="border: 1px solid white;"
                        href="<?php echo $front ?>/cadastro.php">Cadastro</a>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

            </div>
        </nav>
    </header>


    <section style=" display:flex; align-content: center;  justify-content: center; height:100vh; " >
        <div class="container"
            style=" display:flex;    justify-content: center; align-items: center; flex-direction: row;">
            <div class="container" style="border: 2px solid black;">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>

                            <th scope="col"> ID Do Produto </th>
                            <th scope="col"> Produtos </th>
                            <th scope="col"> Quantidade </th>
                            <th scope="col"> $Valor </th>
                            <th scope="col"> $disponivel </th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $produto): ?>
                        <tr id="produto-<?= $produto['id'] ?>">
                            <th scope="row"><?= $produto['id'] ?></th>
                            <td> <?= htmlspecialchars($produto['nome']) ?> </td>
                            <td> <?= $produto['estoque']?></td>
                            <td> $<?= $produto['preco']?></td>
                            <td> <?= $produto['disponivel']?></td>
                            <td>
                                <form method="post" onsubmit="return confirmarExclusao(this);"
                                    action="../backend/deletar.php">
                                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                                    <button class="btn btn-danger btn-sm"
                                        onclick="excluirProduto(<?= $produto['id'] ?>)">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function confirmarExclusao(form) {
        const confirmacao = confirm("Tem certeza que deseja excluir este produto?");
        return confirmacao; // só envia o form se for true
    }
    </script>


</body>

</html>