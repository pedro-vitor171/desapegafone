<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function sanitizeInput($input) {
        $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input); 
        return trim($input); 
    }

    $nome = sanitizeInput($_POST['nome']);
    $cnpj = sanitizeInput($_POST['cnpj']);
    $telefone = sanitizeInput($_POST['telefone']);
    $email = sanitizeInput($_POST['email']);
    $endereco = sanitizeInput($_POST['endereco']);
    $marca_id = sanitizeInput($_POST['marca']);

    try {
        $sql = "INSERT INTO fornecedor (nome, cnpj, telefone, email, endereco, marca_id) 
                VALUES (:nome, :cnpj, :telefone, :email, :endereco, :marca_id)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':marca_id', $marca_id);

        $stmt->execute();

        header("Location: ../php/loginFn.php?message=success");
        exit();
    } catch (PDOException $e) {
        header("Location: ../php/cadastroFn.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
