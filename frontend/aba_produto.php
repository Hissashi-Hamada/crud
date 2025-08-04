<?php
include __DIR__ . '/../backend/config.php';
include __DIR__ . '/../backend/verificacao.php';
include __DIR__ . '/../layout/cabecalho.php';


// SELECT produtos
$sql = "SELECT * FROM produtos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// TRATAMENTO DE FORMULÁRIO
if ($_POST) {
    $nome = trim($_POST['nome'] ?? '');
    $preco = floatval($_POST['preco'] ?? 0);
    $estoque = intval($_POST['estoque'] ?? 0);
    $disponivel = isset($_POST['disponivel']) ? 1 : 0;

    if (!empty($_POST['id'])) {
        // UPDATE
        $id = intval($_POST['id']);
        $sql = "UPDATE produtos 
                SET nome = :nome, preco = :preco, estoque = :estoque, disponivel = :disponivel 
                WHERE id = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
    } else {
        // INSERT
        $sql = "INSERT INTO produtos (nome, preco, estoque, disponivel) 
                VALUES (:nome, :preco, :estoque, :disponivel)";
        $stmt = $pdo->prepare($sql);
    }

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


    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Lista de Produtos</h2>

            <div class="mb-3 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    onclick="adicionar_produto()">
                    Adicionar
                </button>
            </div>

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
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    onclick='editar_produto(<?= json_encode($produto) ?>)'>
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
                    <form action="aba_produto.php" method="post">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar Produto</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input id="id" type="hidden" name="id">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Produto</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço (R$)</label>
                                <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
                            </div>
                            <div class="mb-3">
                                <label for="estoque" class="form-label">Quantidade em Estoque</label>
                                <input type="number" class="form-control" id="estoque" name="estoque" required>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="disponivel" name="disponivel"
                                    value="1">
                                <label class="form-check-label" for="disponivel">Disponível para venda</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
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
        document.getElementById('exampleModalLabel').innerHTML = 'Adicionar produto';
        document.getElementById('id').value = '';
        document.getElementById('nome').value = '';
        document.getElementById('preco').value = '';
        document.getElementById('estoque').value = '';
        document.getElementById('disponivel').checked = false;
    }

    function editar_produto(produto) {
        document.getElementById('exampleModalLabel').innerHTML = 'Editar produto';
        document.getElementById('id').value = produto.id;
        document.getElementById('nome').value = produto.nome;
        document.getElementById('preco').value = produto.preco;
        document.getElementById('estoque').value = produto.estoque;
        document.getElementById('disponivel').checked = produto.disponivel == 1;
    }
    </script>

<?php
include __DIR__ . '/../layout/rodape.php';
?>