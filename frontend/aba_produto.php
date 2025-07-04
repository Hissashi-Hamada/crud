<?php
include '../backend/config.php';

$sql = "SELECT * FROM produtos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $public ?>/css/aba_produtos.css"> <!-- Corrigido espaço -->
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

                <div class="d-flex gap-2">
                    <a class="btn btn-primary" href="<?php echo $front ?>/login.php">Login</a>
                    <a class="btn btn-success" href="<?php echo $front ?>/cadastro.php">Cadastro</a>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Lista de Produtos</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor (R$)</th>
                            <th>Disponível</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $produto): ?>
                        <tr id="produto-<?= $produto['id'] ?>">
                            <td><?= $produto['id'] ?></td>
                            <td><?= htmlspecialchars($produto['nome']) ?></td>
                            <td><?= $produto['estoque'] ?></td>
                            <td><?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            <td><?= $produto['disponivel'] ? 'Sim' : 'Não' ?></td>
                            <td class="d-flex gap-2">
                                <!-- Botão Editar -->
                                <a href="<?php echo $front ?>/editar_produto.php?id=<?= $produto['id'] ?>"
                                    class="btn btn-sm btn-warning">
                                    Editar
                                </a>

                                <!-- Botão Excluir -->
                                <form method="post" action="../backend/deletar.php"
                                    onsubmit="return confirmarExclusao();">
                                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                                    <button class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($produtos)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Nenhum produto encontrado.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function confirmarExclusao() {
        return confirm("Tem certeza que deseja excluir este produto?");
    }
    </script>
</body>

</html>