<?php
session_start(); // Certifique-se de iniciar a sessão
require_once '../../cruds/conexao.php';

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$area = filter_input(INPUT_POST, 'area', FILTER_SANITIZE_STRING);
$page = filter_input(INPUT_POST, 'page', FILTER_SANITIZE_STRING);

function excluirVenda($id)
{
    global $pdo;
    $sql = "DELETE FROM venda WHERE id_venda = :id";
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

if ($area === 'vendas') {
    if (excluirVenda($id)) {
        $_SESSION['message'] = "Compra cancelada com sucesso!";
    } else {
        $_SESSION['message'] = "Não foi possível excluir a compra.";
    }
    header('Location: ../' . $area . '.php');
    exit;
}

if ($page == 'sessao') {
    header('Location: ../../sessao/' . $page . '.php');
    exit;
} elseif ($page == 'usuarios') {
    header('Location: ../../dados/' . $page . '.php');
    exit;
} else {
    $_SESSION['message'] = "Página não reconhecida.";
    header('Location: ../../index.php');
    exit;
}
