<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $geracao = $_POST['geracao'];
    $marca_id = $_POST['marca'];
    $valor = floatval($_POST['valor']); 
    $estoque = intval($_POST['estoque']);

    if (empty($nome) || empty($marca_id) || empty($geracao) || empty($valor) || empty($estoque)) {
        echo "<script>alert('Por favor, preencha todos os campos.');</script>";
        header('location: ../php/cadastropd.php');
    }

    $sql = "INSERT INTO celulares (nome, marca_id, geracao, valor, estoque) VALUES (:nome, :marca_id, :geracao, :valor, :estoque)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':marca_id', $marca_id, PDO::PARAM_INT);
    $stmt->bindParam(':geracao', $geracao, PDO::PARAM_INT);
    $stmt->bindParam(':valor', $valor, PDO::PARAM_STR); 
    $stmt->bindParam(':estoque', $estoque, PDO::PARAM_INT);


    try {
        $stmt->execute();
        echo "<script>alert('Celular cadastrado com sucesso!');</script>";
        echo "<script>window.location.href = '../dados/produtos.php'</script>";
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') { 
            echo "<script>alert('Marca inválida.');</script>";
        } else {
            echo "Erro ao inserir o celular: " . $e->getMessage();
        }
    }
}