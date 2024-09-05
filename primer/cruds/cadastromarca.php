<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function sanitizeInput($input) {
        $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input);
        return trim($input); 
    }

    $nome = sanitizeInput($_POST['nome']);

    if (empty($nome)) {
        echo "<script>alert('O nome da marca é obrigatório.');</script>";
        echo "<script>window.location.href = '../dados/marcas.php';</script>";
        exit();
    }

    try {
        $sql = "INSERT INTO marca (nome) VALUES (:nome)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->execute();

        echo "<script>alert('Cadastro de marca feito com sucesso!');</script>";
        echo "<script>window.location.href = '../dados/marcas.php';</script>";
        exit();
    } catch (PDOException $e) {
        echo "<script>alert('Erro ao cadastrar a marca: " . addslashes($e->getMessage()) . "');</script>";
        echo "<script>window.location.href = '../dados/marcas.php';</script>";
        exit();
    }
}
