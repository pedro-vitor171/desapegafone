<?php
require_once 'conexao.php';

session_start();

function limpezaInput($input) {
    $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input);
    return trim($input); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = limpezaInput($_POST['nome']);
    $geracao = limpezaInput($_POST['geracao']);
    $marca_id = limpezaInput($_POST['marca']);
    $valor = floatval(limpezaInput($_POST['valor'])); 
    $estoque = intval(limpezaInput($_POST['estoque']));
    $id = limpezaInput($_POST['id']);

    if (empty($nome) || empty($marca_id) || empty($geracao) || empty($valor) || empty($estoque)) {
        $_SESSION['message'] = 'Por favor, preencha todos os campos.';
        header('Location: ../php/cadastropd.php');
        exit();
    }

    if ($valor <= 0) {
        $_SESSION['message'] = 'O valor não pode ser negativo.';
        header('Location: ../php/cadastropd.php');
        exit();
    }

    if ($estoque <= 0) {
        $_SESSION['message'] = 'O estoque não pode ser negativo.';
        header('Location: ../php/cadastropd.php');
        exit();
    }

    try {
        $sql_verificar = "SELECT COUNT(*) FROM celulares 
                          WHERE nome = :nome AND marca_id = :marca_id AND geracao = :geracao";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->bindParam(':nome', $nome);
        $stmt_verificar->bindParam(':marca_id', $marca_id, PDO::PARAM_INT);
        $stmt_verificar->bindParam(':geracao', $geracao, PDO::PARAM_INT);
        $stmt_verificar->execute();
        
        if ($stmt_verificar->fetchColumn() > 0) {
            $_SESSION['message'] = 'Já existe um produto cadastrado com os mesmos dados.';
            header('Location: ../php/cadastropd.php');
            exit();
        }

        $sql = "INSERT INTO celulares (nome, marca_id, geracao, valor, estoque, fornecedor_id) 
                VALUES (:nome, :marca_id, :geracao, :valor, :estoque, :fornecedor_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':fornecedor_id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':marca_id', $marca_id, PDO::PARAM_INT);
        $stmt->bindParam(':geracao', $geracao, PDO::PARAM_INT);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR); 
        $stmt->bindParam(':estoque', $estoque, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['message'] = 'Celular cadastrado com sucesso!';
        header('Location: ../dados/produtos.php');
        exit();

    } catch (PDOException $e) {
        if ($e->getCode() === '23000') { 
            $_SESSION['message'] = 'Marca inválida.';
        } else {
            $_SESSION['message'] = 'Erro ao inserir o celular: ' . $e->getMessage();
        }
        header('Location: ../php/cadastropd.php');
        exit();
    }
}
