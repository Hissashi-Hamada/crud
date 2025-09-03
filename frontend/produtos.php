<?php
include '../backend/config.php';
include '../backend/verificacao.php';
$sql = "SELECT * FROM produtos";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Lista de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h1 class="mb-4">Produtos</h1>

        <a href="../backend/adicionar.php" class="btn btn-success mb-3">Adicionar Produto</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nome'] ?></td>
                    <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
                    <td><?= $row['estoque'] ?></td>
                    <td>
                        <a href="../backend/editar.php $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="../backend/deletar.php?= $row['id'] ?>" class="btn btn-danger btn-sm">Deletar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>

</html>