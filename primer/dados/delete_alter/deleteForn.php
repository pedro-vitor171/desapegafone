<?php
require_once '../../cruds/conexao.php';

$id = $_POST['id'];
$area = $_POST['area'];
$page = $_POST['page'];

function excluirFornecedor($id)
{
    global $pdo;
    $sql = "DELETE FROM fornecedor WHERE id_fornecedor = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        $pdo->beginTransaction();
        $stmt->execute();
        $affectedRows = $stmt->rowCount();
        $pdo->commit();
        return $affectedRows > 0;
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Erro ao deletar registro: " . $e->getMessage() . " - Consulta: " . $sql);
        return false;
    }
}

if ($area === 'fornecedores') {
    if (excluirFornecedor($id)) {
        echo '<script>alert("Registro excluído com sucesso!");</script>';
    } else {
        echo '<script>alert("Não foi possível excluir o registro.");</script>';
    }
    header('Location: ../' . $area . '.php');
    exit(); // Adiciona exit após header para garantir que o script não continue
} 
