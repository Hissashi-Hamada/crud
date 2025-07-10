<?php
include '../backend/config.php';
include '../backend/verificacao.php';

$id_user = $_SESSION['id'];
$sql = "SELECT * FROM cliente where id_user = $id_user";
$stmt = $pdo->prepare($sql); 
$stmt->execute();     

$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC); 
$nome = $_REQUEST['nome'] ?? '';
$email = $_REQUEST['email'] ?? '';
$telefone = $_REQUEST['telefone'] ?? '';
$data_nacimento = $_REQUEST['data_nacimeno'] ?? '';

$_SESSION['cliente'] = [
    'nome' => $nome,
    'email' => $email
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $id_user= $_POST['id_user'];
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';

    if (!$id) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM cliente WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            die("Erro: E-mail já cadastrado.");
        }

        $sql = "INSERT INTO cliente (id_user, nome, email, telefone, data_nascimento) 
                VALUES (:id_user, :nome, :email, :telefone, :data_nascimento)";
    } else {
        $sql = "UPDATE cliente 
                SET nome = :nome, email = :email, telefone = :telefone, data_nascimento = :data_nascimento 
                WHERE id = :id";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':data_nascimento', $data_nascimento);
    if ($id) {
        $stmt->bindParam(':id', $id);
    }

    $stmt->execute();
    header('Location: cliente.php');
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

<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color:rgb(153, 155, 158);
    }

    .table tbody tr {
        background-color: #212529; /* tom escuro */
        color: #fff;               /* texto branco */
    }

    .table tbody tr:hover {
        background-color: #343a40; /* tom mais claro ao passar o mouse */
    }

    .table thead {
        background-color: #000;
        color: #fff;
    }

    .table td, .table th {
        border-color: #444;
    }

    .tabela-escura tbody tr {
        background-color: #1a1a1a; /* fundo bem escuro */
        color: white;
    }

    .tabela-escura thead {
        background-color: #000; /* cabeçalho mais escuro */
        color: white;
    }

    td{
        background-color: #000;
    }

</style>

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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">adicionar cliente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="cliente.php" method="post">

                            <input id="id" type="hidden" name="id" value="">
                            <input id="id" type="hidden" name="id_user" value="<?php echo $_SESSION['id'];?>">
                            <!-- Nome do Cliente -->
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Cliente</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>

                            <!-- Preço -->
                            <div class="mb-3">
                                <label for="preco" class="form-label">Email</label>
                                <input type="email" step="0.01" class="form-control" id="email" name="email" required>
                            </div>

                            <!-- Estoque -->
                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="int" class="form-control" id="telefone" name="telefone" required>
                            </div>

                            <!-- Estoque -->
                            <div class="mb-3">
                                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
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
</body>

</html>