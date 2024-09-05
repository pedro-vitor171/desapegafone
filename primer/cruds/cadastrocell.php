<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function sanitizeInput($input) {
        // Remove caracteres de retrocesso e espaços em branco extras
        $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input); // Remove caracteres de controle
        return trim($input); // Remove espaços em branco no início e no final
    }

    $nome = sanitizeInput($_POST['nome']);
    $geracao = sanitizeInput($_POST['geracao']);
    $marca_id = sanitizeInput($_POST['marca']);
    $valor = floatval(sanitizeInput($_POST['valor'])); 
    $estoque = intval(sanitizeInput($_POST['estoque']));
    $id = sanitizeInput($_POST['id']);

    if (empty($nome) || empty($marca_id) || empty($geracao) || empty($valor) || empty($estoque)) {
        echo "<script>alert('Por favor, preencha todos os campos.');</script>";
        echo "<script>window.location.href = '../php/cadastropd.php';</script>";
        exit();
    }

    if ($valor < 0) {
        echo "<script>alert('O valor não pode ser negativo.');</script>";
        echo "<script>window.location.href = '../php/cadastropd.php';</script>";
        exit();
    }

    if ($estoque < 0) {
        echo "<script>alert('O estoque não pode ser negativo.');</script>";
        echo "<script>window.location.href = '../php/cadastropd.php';</script>";
        exit();
    }

    $sql = "INSERT INTO celulares (nome, marca_id, geracao, valor, estoque, fornecedor_id) VALUES (:nome, :marca_id, :geracao, :valor, :estoque, :fornecedor_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':fornecedor_id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':marca_id', $marca_id, PDO::PARAM_INT);
    $stmt->bindParam(':geracao', $geracao, PDO::PARAM_INT);
    $stmt->bindParam(':valor', $valor, PDO::PARAM_STR); 
    $stmt->bindParam(':estoque', $estoque, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo "<script>alert('Celular cadastrado com sucesso!');</script>";
        echo "<script>window.location.href = '../dados/produtos.php';</script>";
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') { 
            echo "<script>alert('Marca inválida.');</script>";
        } else {
            echo "Erro ao inserir o celular: " . $e->getMessage();
        }
    }
}
