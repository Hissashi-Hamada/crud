    <?php
include '../backend/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM cliente WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location:  ../frontend/cliente.php?msg=excluido");
        exit;
    } else {
        echo "Erro ao excluir o cliente.";
    }
} else {
    echo "Requisição inválida.";
    
}
?>
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'excluido'): ?>
    <div class="alert alert-success">cliente excluído com sucesso!</div>
    <?php endif; ?>