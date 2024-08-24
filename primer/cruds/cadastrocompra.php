<?php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $celular_id = $_POST['celular_id'];
    $usuario_id = $_POST['comprador'];
    $data = date('Y-m-d');
    $valor = $_POST['valor'];

    if (empty($celular_id) || empty($usuario_id) || empty($valor) || $valor <= 0) {
        echo "<script>alert('Todos os campos são obrigatórios e o valor deve ser positivo.');</script>";
        echo "<script>window.location.href = '../sessao/sessao.php'</script>";
        exit;
    }

    $data_formatada = date('Y-m-d', strtotime($data));

    $sql_verificar_usuario = "SELECT id_usuario FROM usuarios WHERE id_usuario = :comprador";
    $stmt_verificar_usuario = $pdo->prepare($sql_verificar_usuario);
    $stmt_verificar_usuario->bindParam(':comprador', $usuario_id);
    $stmt_verificar_usuario->execute();
    $usuario_id = $stmt_verificar_usuario->fetchColumn();
    
    if (!$usuario_id) {
        echo "<script>alert('Não foi encontrado um usuário com o ID informado.');</script>";
        echo "<script>window.location.href = ''../sessao/sessao.php''</script>";
        exit;
    }

    $sql_verificar_estoque = "SELECT estoque FROM celulares WHERE id_celular = :celular_id";
    $stmt_verificar_estoque = $pdo->prepare($sql_verificar_estoque);
    $stmt_verificar_estoque->bindParam(':celular_id', $celular_id);
    $stmt_verificar_estoque->execute();
    $estoque_atual = $stmt_verificar_estoque->fetchColumn();

    if ($estoque_atual <= 0) {
        echo "<script>alert('O produto está indisponível.');</script>";
        echo "<script>window.location.href = '../sessao/user.php'</script>";
        exit;
    }

    $sql = "INSERT INTO venda (celular_id, usuario_id, data_venda, valor) VALUES (:celular_id, :usuario_id, :data, :valor)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':celular_id', $celular_id);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':data', $data_formatada);
    $stmt->bindParam(':valor', $valor);

    try {
        $stmt->execute();
        $novo_estoque = $estoque_atual - 1;
        $sql_atualizar_estoque = "UPDATE celulares SET estoque = :novo_estoque WHERE id_celular = :celular_id";
        $stmt_atualizar_estoque = $pdo->prepare($sql_atualizar_estoque);
        $stmt_atualizar_estoque->bindParam(':novo_estoque', $novo_estoque);
        $stmt_atualizar_estoque->bindParam(':celular_id', $celular_id);
        $stmt_atualizar_estoque->execute();
        echo "<script>alert('Compra feita com sucesso!');</script>";
        echo "<script>window.location.href = '../sessao/sessao.php'</script>";
    } catch (PDOException $e) {
        echo "Erro ao inserir a venda: " . $e->getMessage();
    }
    } else {
        echo "<script>alert('O celular informado não existe.');</script>";
        echo "<script>window.location.href = '../sessao/sessao.php'</script>";
    }

