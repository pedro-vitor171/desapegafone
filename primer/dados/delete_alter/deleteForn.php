<?php
require_once '../../cruds/conexao.php';
session_start();

$id = $_POST['id'];
$area = $_POST['area'];

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
        error_log("Erro ao deletar Fornecedor: " . $e->getMessage() . " - Consulta: " . $sql);
        return false;
    }
}

if ($area === 'fornecedores') {
    if (excluirFornecedor($id)) {
        $_SESSION['message'] = 'Fornecedor excluído com sucesso!';
    } else {
        $_SESSION['message'] = 'Não foi possível excluir o Fornecedor.';
    }
    header('Location: ../' . $area . '.php');
    exit();
}