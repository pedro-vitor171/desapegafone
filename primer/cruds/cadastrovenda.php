<?php
require_once 'conexao.php';
session_start();

function limpezaInput($input) {
    $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input);
    return trim($input); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $celular_id = limpezaInput($_POST['produto']);
    $comprador = limpezaInput($_POST['comprador']);
    $data = limpezaInput($_POST['data']);
    $valor = floatval(limpezaInput($_POST['valor'])); 

    if (empty($celular_id) || empty($comprador) || empty($data) || empty($valor)) {
        $_SESSION['message'] = 'Todos os campos são obrigatórios.';
        header('Location: ../php/cadastrovd.php');
        exit;
    }

    $sql_verificar_usuario = "SELECT id_usuario FROM usuarios WHERE id_usuario = :comprador";
    $stmt_verificar_usuario = $pdo->prepare($sql_verificar_usuario);
    $stmt_verificar_usuario->bindParam(':comprador', $comprador);
    $stmt_verificar_usuario->execute();
    $usuario_id = $stmt_verificar_usuario->fetchColumn();
    
    if (!$usuario_id) {
        $_SESSION['message'] = "Não foi encontrado um usuário com o ID informado.";
        header('Location: ../php/cadastrovd.php');
        exit;
    }

    $sql_verificar_estoque = "SELECT valor, estoque FROM celulares WHERE id_celular = :celular_id";
    $stmt_verificar_estoque = $pdo->prepare($sql_verificar_estoque);
    $stmt_verificar_estoque->bindParam(':celular_id', $celular_id);
    $stmt_verificar_estoque->execute();
    $resultado = $stmt_verificar_estoque->fetch(PDO::FETCH_ASSOC);

    if (!$resultado) {
        $_SESSION['message'] = 'Produto não encontrado.';
        header('Location: ../php/cadastrovd.php');
        exit;
    }

    $estoque_atual = $resultado['estoque'];
    $valor_produto = $resultado['valor'];

    if ($estoque_atual <= 0) {
        $_SESSION['message'] = 'O produto está indisponível.';
        header('Location: ../php/cadastrovd.php');
        exit;
    }

    if ($valor < $valor_produto) {
        $_SESSION['message'] = 'O valor da venda não pode ser inferior ao valor do produto.';
        header('Location: ../php/cadastrovd.php');
        exit;
    }

    $sql = "INSERT INTO venda (celular_id, usuario_id, data_venda, valor) VALUES (:celular_id, :usuario_id, :data, :valor)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':celular_id', $celular_id);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':data', $data);
    $stmt->bindParam(':valor', $valor);

    $novo_estoque = $estoque_atual - 1;
    $sql_atualizar_estoque = "UPDATE celulares SET estoque = :novo_estoque WHERE id_celular = :celular_id";
    $stmt_atualizar_estoque = $pdo->prepare($sql_atualizar_estoque);
    $stmt_atualizar_estoque->bindParam(':novo_estoque', $novo_estoque);
    $stmt_atualizar_estoque->bindParam(':celular_id', $celular_id);
    $stmt_atualizar_estoque->execute();

    try {
        $stmt->execute();
        $_SESSION['message'] = "Venda cadastrada com sucesso!";
        header('Location: ../dados/vendas.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erro ao inserir a venda: " . $e->getMessage();
        header('Location: ../php/cadastrovd.php');
        exit;
    }
}
