<?php
session_start();
require_once '../cruds/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function sanitizeInput($input) {
        $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input); 
        return trim($input); 
    }

    $celular_id = sanitizeInput($_POST['celular_id']);
    $usuario_id = sanitizeInput($_POST['comprador']);
    $data = date('Y-m-d');
    $quantidade = intval(sanitizeInput($_POST['quantidade']));
    $valor_unitario = floatval(sanitizeInput($_POST['valor_unitario']));
    $valor_total = floatval(sanitizeInput($_POST['valor_total']));

    if (empty($celular_id) || empty($usuario_id) || empty($valor_total) || $valor_total <= 0 || empty($quantidade) || $quantidade <= 0) {
        echo "<script>alert('Todos os campos são obrigatórios e a quantidade e o valor devem ser positivos.');</script>";
        echo "<script>window.location.href = '../sessao/sessao.php';</script>";
        exit;
    }

    $data_formatada = date('Y-m-d', strtotime($data));

    // Verificar se o usuário existe
    $sql_verificar_usuario = "SELECT id_usuario FROM usuarios WHERE id_usuario = :comprador";
    $stmt_verificar_usuario = $pdo->prepare($sql_verificar_usuario);
    $stmt_verificar_usuario->bindParam(':comprador', $usuario_id);
    $stmt_verificar_usuario->execute();
    $usuario_id = $stmt_verificar_usuario->fetchColumn();
    
    if (!$usuario_id) {
        echo "<script>alert('Não foi encontrado um usuário com o ID informado.');</script>";
        echo "<script>window.location.href = '../sessao/sessao.php';</script>";
        exit;
    }

    $sql_verificar_estoque = "SELECT estoque FROM celulares WHERE id_celular = :celular_id";
    $stmt_verificar_estoque = $pdo->prepare($sql_verificar_estoque);
    $stmt_verificar_estoque->bindParam(':celular_id', $celular_id);
    $stmt_verificar_estoque->execute();
    $estoque_atual = $stmt_verificar_estoque->fetchColumn();

    if ($estoque_atual < $quantidade) {
        echo "<script>alert('Quantidade disponível insuficiente.');</script>";
        echo "<script>window.location.href = '../sessao/user.php';</script>";
        exit;
    }

    $sql = "INSERT INTO venda (celular_id, usuario_id, data_venda, valor, quantidade) VALUES (:celular_id, :usuario_id, :data, :valor, :quantidade)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':celular_id', $celular_id);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':data', $data_formatada);
    $stmt->bindParam(':valor', $valor_total);
    $stmt->bindParam(':quantidade', $quantidade);

    try {
        $stmt->execute();
        $novo_estoque = $estoque_atual - $quantidade;
        $sql_atualizar_estoque = "UPDATE celulares SET estoque = :novo_estoque WHERE id_celular = :celular_id";
        $stmt_atualizar_estoque = $pdo->prepare($sql_atualizar_estoque);
        $stmt_atualizar_estoque->bindParam(':novo_estoque', $novo_estoque);
        $stmt_atualizar_estoque->bindParam(':celular_id', $celular_id);
        $stmt_atualizar_estoque->execute();
        echo "<script>alert('Compra feita com sucesso!');</script>";
        echo "<script>window.location.href = '../sessao/sessao.php';</script>";
    } catch (PDOException $e) {
        echo "Erro ao inserir a venda: " . $e->getMessage();
    }
}
