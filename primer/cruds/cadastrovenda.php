<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $celular_id = $_POST['produto'];
    $comprador = $_POST['comprador'];
    $data = $_POST['data'];
    $valor = $_POST['valor'];

    if (empty($celular_id) || empty($comprador) || empty($data) || empty($valor)) {
        echo "<script>alert('Todos os campos são obrigatórios.');</script>";
        echo "<script>window.location.href = '../php/cadastrovd.php'</script>";
        exit;
    }

    $data_formatada = date('Y-m-d', strtotime($data));

    $sql_verificar_usuario = "SELECT id_usuario FROM usuarios WHERE id_usuario = :comprador";
    $stmt_verificar_usuario = $pdo->prepare($sql_verificar_usuario);
    $stmt_verificar_usuario->bindParam(':comprador', $comprador);
    $stmt_verificar_usuario->execute();
    $usuario_id = $stmt_verificar_usuario->fetchColumn();
    
    if (!$usuario_id) {
        echo "<script>alert('Não foi encontrado um usuário com o ID informado.');</script>";
        echo "<script>window.location.href = '../php/cadastrovd.php'</script>";
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
        echo "<script>alert('Venda cadastrada com sucesso!');</script>";
        echo "<script>window.location.href = '../dados/vendas.php'</script>";
    } catch (PDOException $e) {
        echo "Erro ao inserir a venda: " . $e->getMessage();
    }
    } else {
        echo "<script>alert('O celular informado não existe.');</script>";
        echo "<script>window.location.href = '../php/cadastrovd.php'</script>";
    }

