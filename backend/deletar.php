    <?php
include '../backend/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location:  ../frontend/aba_produto.php?msg=excluido");
        exit;
    } else {
        echo "Erro ao excluir o produto.";
    }
} else {
    echo "Requisição inválida.";
    
}
?>
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'excluido'): ?>
    <div class="alert alert-success">Produto excluído com sucesso!</div>
    <?php endif; ?>