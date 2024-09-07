<?php
require_once 'conexao.php';

session_start(); // Inicie a sessão para usar variáveis de sessão

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function limpezaInput($input) {
        $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input);
        return trim($input); 
    }

    $nome = limpezaInput($_POST['nome']);

    if (empty($nome)) {
        $_SESSION['message'] = 'O nome da marca é obrigatório.';
        header('Location: ../dados/marcas.php');
        exit();
    }

    try {
        $sql_verificar = "SELECT COUNT(*) FROM marca WHERE nome = :nome";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->bindParam(':nome', $nome);
        $stmt_verificar->execute();
        
        if ($stmt_verificar->fetchColumn() > 0) {
            $_SESSION['message'] = 'A marca já está cadastrada.';
            header('Location: ../php/cadastromarca.php');
            exit();
        }

        $sql = "INSERT INTO marca (nome) VALUES (:nome)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();

        $_SESSION['message'] = 'Cadastro de marca feito com sucesso!';
        header('Location: ../dados/marcas.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Erro ao cadastrar a marca: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        header('Location: ../dados/marcas.php');
        exit();
    }
}
