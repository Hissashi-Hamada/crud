<?php
include '../backend/config.php';

session_start();

$sql = "SELECT * FROM produtos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_POST) {


    if ($_POST['id']) {
        $id = $_POST['id'];
        $nome = $_POST['nome'] ?? '';
        $preco = $_POST['preco'] ?? '';
        $estoque = $_POST['estoque'] ?? '';
        $disponivel = isset($_POST['disponivel']) ? 1 : 0; // checkbox tratamento

        $sql = "UPDATE produtos 
            SET nome = :nome, preco = :preco, estoque = :estoque, disponivel = :disponivel 
            WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':estoque', $estoque);
        $stmt->bindParam(':disponivel', $disponivel);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header('Location: aba_produto.php');
            exit();
        }
    }

    $nome = $_POST['nome'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $estoque = $_POST['estoque'] ?? '';
    $disponivel = $_POST['disponivel'] ?? '';
    // print_r(['nome' => $nome,'preco' => $preco,'estoque' => $estoque,'disponivel' => $disponivel]) ;

    $sql = "INSERT INTO produtos (nome, preco, estoque, disponivel) VALUES (:nome, :preco, :estoque, :disponivel)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':estoque', $estoque);
    $stmt->bindParam(':disponivel', $disponivel);

    if ($stmt->execute()) {
        header('Location: aba_produto.php');
        exit();
    }
}


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
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= $front ?>/pagina_inicial.php">Menu</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Alternar navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    </ul>
                    <?php if (($_SESSION['id'] == null)) { ?>
                    <div class="d-flex gap-2">
                        <a class="btn btn-primary" style="border: 1px solid white;"
                            href="<?= $front ?>/login.php">Login</a>
                        <a class="btn btn-success" style="border: 1px solid white;"
                            href="<?= $front ?>/cadastro.php">Cadastro</a>
                    </div>
                    <?php } else { ?>
                    <div class="d-flex gap-2">
                        <h4 class="text-light"><?php echo $_SESSION['nome'] ?></h4>
                        <a class="btn btn-primary" style="border: 1px solid white;"
                            href="<?= $back ?>/deslogar.php">Sair</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </nav>
    </header>


    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Lista de Produtos</h2>

            <div class="mb-3 text-end">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    onclick="adicionar_produto()">
                    Adicionar
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dar">
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
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    onclick='editar_produto(<?php echo json_encode($produto); ?>)'>
                                    Editar
                                </button>

                                <form method="post" action="../backend/deletar.php"
                                    onsubmit="return confirmarExclusao();">
                                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                                    <button class="btn btn-danger">Excluir</button>
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
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar Produto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="aba_produto.php" method="post">

                            <input id="id" type="hidden" name="id" value="">
                            <!-- Nome do produto -->
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Produto</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>

                            <!-- Preço -->
                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço (R$)</label>
                                <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
                            </div>

                            <!-- Estoque -->
                            <div class="mb-3">
                                <label for="estoque" class="form-label">Quantidade em Estoque</label>
                                <input type="int" class="form-control" id="estoque" name="estoque" required>
                            </div>

                            <!-- Disponível - checkbox como interruptor -->
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="disponivel" name="disponivel"
                                    value="1">
                                <label class="form-check-label" for="disponivel">Disponível para venda</label>
                            </div>

                            Botão de envio
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function confirmarExclusao() {
        return confirm("Tem certeza que deseja excluir este produto?");
    }

    function adicionar_produto() {
        document.getElementById('exampleModalLabel').innerHTML = 'Adicionar produto'
        document.getElementById('id').value = ''
        document.getElementById('nome').value = ''
        document.getElementById('preco').value = ''
        document.getElementById('estoque').value = ''
        document.getElementById('disponivel').checked = ''
    }

    function editar_produto(produto) {
        console.log(produto); // objeto JS com todas as propriedades
        // alert('Produto: ' + produto.nome + ', Preço: ' + produto.preco);
        // aqui pode preencher seu modal, etc.
        document.getElementById('exampleModalLabel').innerHTML = 'Editar produto'
        document.getElementById('nome').value = produto.nome
        document.getElementById('id').value = produto.id
        document.getElementById('preco').value = produto.preco
        document.getElementById('estoque').value = produto.estoque
        document.getElementById('disponivel').checked = produto.disponivel ? 1 : 0
    }
    </script>
</body>

</html>