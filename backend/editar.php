<?php
include '../backend/config.php';

if (!isset($_GET['id'])) {
    die("ID não fornecido.");
}

$id = $_GET['id'];

$sql = "SELECT * FROM produtos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Editar Produto</h2>

    <form action="atualizar_produto.php" method="post">
        <input type="hidden" name="id" value="<?= $produto['id'] ?>">

        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($produto['nome']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Quantidade:</label>
            <input type="number" name="quantidade" class="form-control" value="<?= $produto['quantidade'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Valor:</label>
            <input type="text" name="valor" class="form-control" value="<?= $produto['valor'] ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="aba_produto.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>
