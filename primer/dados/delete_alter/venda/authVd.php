<?php
require_once '../../../cruds/conexao.php';
session_start();

function limpezaInput($input) {
    $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input); 
    return trim($input); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = limpezaInput($_POST['id']);
        $produto = limpezaInput($_POST['produto']);
        $comprador = limpezaInput($_POST['comprador']);
        $data = limpezaInput($_POST['data']);
        $valor = limpezaInput($_POST['valor']);

        $sql_produto = "SELECT valor FROM celulares WHERE id_celular = :produto";
        $stmt_produto = $pdo->prepare($sql_produto);
        $stmt_produto->bindParam(':produto', $produto);
        $stmt_produto->execute();
        $produto_info = $stmt_produto->fetch(PDO::FETCH_ASSOC);

        if (!$produto_info) {
            $_SESSION['message'] = 'Produto não encontrado.';
            header('Location: ../../../dados/vendas.php');
            exit();
        }

        if ($valor < $produto_info['valor']) {
            $_SESSION['message'] = 'O valor da venda não pode ser inferior ao valor normal do produto.';
            header('Location: ../../../dados/vendas.php');
            exit();
        }

        $sql = "UPDATE venda SET celular_id = :produto, usuario_id = :comprador, data_venda = :data, valor = :valor WHERE id_venda = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':produto', $produto);
        $stmt->bindParam(':comprador', $comprador);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Venda alterada com sucesso!';
        } else {
            $_SESSION['message'] = 'Nenhuma linha foi alterada.';
        }

        header('Location: ../../../dados/vendas.php');
        exit();

    } catch (PDOException $e) {
        $_SESSION['message'] = "Erro ao alterar venda: " . $e->getMessage();
        header('Location: ../../../dados/vendas.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'Método de requisição não suportado.';
    header('Location: ../../../dados/vendas.php');
    exit();
}
