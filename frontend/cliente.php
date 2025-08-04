<?php
include __DIR__ . '/../backend/config.php';
include __DIR__ . '/../backend/verificacao.php';
include __DIR__ . '/../layout/cabecalho.php';

$id_user = $_SESSION['id'];
$sql = "SELECT * FROM cliente WHERE id_user = :id_user";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_user', $id_user);
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$nome = $_REQUEST['nome'] ?? '';
$email = $_REQUEST['email'] ?? '';
$telefone = $_REQUEST['telefone'] ?? '';
$data_nascimento = $_REQUEST['data_nascimento'] ?? ''; // Corrigido aqui

$_SESSION['cliente'] = [
    'nome' => $nome,
    'email' => $email
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $id_user = $_POST['id_user'];
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';

    if (!$id) {
        // Verifica se email já existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM cliente WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            die("Erro: E-mail já cadastrado.");
        }

        // INSERT
        $sql = "INSERT INTO cliente (id_user, nome, email, telefone, data_nascimento) 
                VALUES (:id_user, :nome, :email, :telefone, :data_nascimento)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->execute();

    } else {
        // UPDATE
        $sql = "UPDATE cliente 
                SET nome = :nome, email = :email, telefone = :telefone, data_nascimento = :data_nascimento 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->execute();
    }

    header('Location: cliente.php');
    exit;
}
?>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Lista de cliente</h2>

            <div class="mb-3 text-end">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    onclick="adicionar_cliente()">
                    Adicionar
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Data Nacimento</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-dark text-white">
                        <?php foreach ($clientes as $cliente): ?>
                        <tr id="cliente-<?= $cliente['id'] ?>">
                            <td><?= $cliente['id'] ?></td>
                            <td><?= htmlspecialchars($cliente['nome']) ?></td>
                            <td><?= $cliente['email'] ?></td>
                            <td><?= $cliente['telefone'] ?></td>
                            <td><?= $cliente['data_nascimento'] ?></td>
                            <td class="d-flex gap-2">
                                <!-- Botão Editar -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    onclick='editar_cliente(<?php echo json_encode($cliente); ?>)'>
                                    Editar
                                </button>

                                <form method="post" action="../backend/add_exclude_cliente.php"
                                    onsubmit="return confirmarExclusao();">
                                    <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
                                    <button class="btn btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($cliente)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Nenhum cliente encontrado.</td>
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar cliente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>

                    <div class="modal-body">
                        <form action="cliente.php" method="post">
                            <!-- ID do Cliente (oculto) -->
                            <input type="hidden" id="id" name="id" value="">

                            <!-- ID do Usuário (oculto) -->
                            <input type="hidden" name="id_user" value="<?php echo $_SESSION['id']; ?>">

                            <!-- Nome -->
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Cliente</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <!-- Telefone -->
                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" required>
                            </div>

                            <!-- Data de Nascimento -->
                            <div class="mb-3">
                                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento"
                                    required>
                            </div>

                            <!-- Botões -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
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
        return confirm("Tem certeza que deseja excluir este cliente?");
    }

    function adicionar_cliente() {
        document.getElementById('exampleModalLabel').innerHTML = 'Adicionar cliente'
        document.getElementById('id').value = ''
        document.getElementById('nome').value = ''
        document.getElementById('email').value = ''
        document.getElementById('telefone').value = ''
        document.getElementById('data_nacimento').value = ''
    }

    function editar_cliente(cliente) {
        console.log(cliente);

        document.getElementById('exampleModalLabel').innerHTML = 'Editar cliente'
        document.getElementById('id').value = cliente.id
        document.getElementById('nome').value = cliente.nome
        document.getElementById('email').value = cliente.email
        document.getElementById('telefone').value = cliente.telefone
        document.getElementById('data_nascimento').value = cliente.data_nascimento
    }
    </script>
<?php
include __DIR__ . '/../layout/rodape.php';
?>