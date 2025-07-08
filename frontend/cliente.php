<?php
include '../backend/config.php';
session_start();


$sql = "SELECT * FROM cliente";
$stmt = $pdo->prepare($sql);  // preparar a query
$stmt->execute();             // executar a query

$cliente = $stmt->fetchAll(PDO::FETCH_ASSOC); // pegar os dados

// Captura dos dados do request (caso queira usar),
$nome = $_REQUEST['nome'] ?? '';
$email = $_REQUEST['email'] ?? '';
$senha = $_REQUEST['senha'] ?? '';
$telefone = $_REQUEST['telefone'] ?? '';
$data_nacimento = $_REQUEST['data_nacimeno'] ?? '';

// Exemplo de uso: salvar dados na sessão
$_SESSION['cliente'] = [
    'nome' => $nome,
    'email' => $email
];




$sql = "SELECT * FROM cliente";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($clientes);

if ($_POST) {


    if ($_POST['id']) {
        $id = $_POST['id'];
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $data_nacimento = $_POST['data_nacimeno'] ?? '';

        $sql = "UPDATE cliente 
            SET nome = :nome, preco = :preco, estoque = :estoque, disponivel = :disponivel 
            WHERE id = :id";

        $stmt->bindParam(':id', $id);
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':data_nacimento', $data_nacimento);

        if ($stmt->execute()) {
            header('Location: cliente.php');
            print_r('echo');
            exit();
        }
    }

    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $data_nacimento = $_POST['data_nacimeno'] ?? '';
    // print_r(['nome' => $nome,'preco' => $preco,'estoque' => $estoque,'disponivel' => $disponivel]) ;

    $sql = "INSERT INTO cliente (nome, senha, telefone, data_nacimeno) VALUES (:nome, :senha, :telefone, :data_nacimeno)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':data_nacimeno', $data_nacimeno);

    $stmt->execute();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $public ?>/css/cliente.css">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-warning">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= $front ?>/pagina_inicial.php">Menu</a>

                <!-- Botão para toggle do menu mobile -->
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
                            <h4 class="text-dark"><?php echo $_SESSION['nome'] ?></h4>
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
                            <th>Data_Nacimento</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                        <tr id="clientes-<?= $clientes['id'] ?>">
                            <td><?= $cliente['id'] ?></td>
                            <td><?= htmlspecialchars($cliente['nome']) ?></td>
                            <td><?= $cliente['email'] ?></td>
                            <td><?= $cliente['telefone'] ?></td>
                            <td><?= $cliente['data_nascimento'] ?></td>
                            <td class="d-flex gap-2">
                                <!-- Botão Editar -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    onclick='editar_clientes(<?php echo json_encode($cliente); ?>)'>
                                    Editar
                                </button>

                                <form method="post" action="../backend/deletar.php"
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">adicionar cliente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="cliente.php" method="post">

                            <input id="id" type="hidden" name="id" value="">
                            <!-- Nome do Cliente -->
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Cliente</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>

                            <!-- Preço -->
                            <div class="mb-3">
                                <label for="preco" class="form-label">Email</label>
                                <input type="email" step="0.01" class="form-control" id="preco" name="preco" required>
                            </div>

                            <!-- Estoque -->
                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="int" class="form-control" id="estoque" name="estoque" required>
                            </div>

                            <!-- Estoque -->
                            <div class="mb-3">
                                <label for="data_nacimento" class="form-label">data_nacimento</label>
                                <input type="date" class="form-control" id="estoque" name="estoque" required>
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
            return confirm("Tem certeza que deseja excluir este cliente?");
        }

        function adicionar_cliente() {
            document.getElementById('exampleModalLabel').innerHTML = 'Adicionar cliente'
            document.getElementById('id').value = ''
            document.getElementById('nome').value = ''
            document.getElementById('email').value = ''
            document.getElementById('telefone').value = ''
            document.getElementById('data_nacimento').checked = ''
        }

        function editar_cliente(cliente) {
            console.log(cliente); // objeto JS com todas as propriedades
            // alert('cliente: ' + cliente.nome + ', Preço: ' + cliente.preco);
            // aqui pode preencher seu modal, etc.
            document.getElementById('exampleModalLabel').innerHTML = 'Editar cliente'
            document.getElementById('id').value = cliente.id
            document.getElementById('nome').value = cliente.nome
            document.getElementById('email').value = cliente.email
            document.getElementById('telefone').value = cliente.telefone
            document.getElementById('data_nacimento').checked = cliente.data_nacimento ? 1 : 0
        }
    </script>
</body>

</html>