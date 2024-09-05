<?php

require_once 'conexao.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function sanitizeInput($input) {
        $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input); 
        return trim($input); 
    }

    $nome = sanitizeInput($_POST['nome']);
    $cnpj = sanitizeInput($_POST['cnpj']);
    $email = sanitizeInput($_POST['email']);
    $senha = sanitizeInput($_POST['senha']);

    if (empty($nome) || empty($cnpj) || empty($email) || empty($senha)) {
        header("Location: ../php/cadastroAdm.html?error=campo_vazio");
        exit;
    }

    try {
        $sql_verificar = "SELECT * FROM adm WHERE cnpj = :cnpj";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->bindParam(':cnpj', $cnpj);
        $stmt_verificar->execute();

        if ($stmt_verificar->rowCount() > 0) {
            header("Location: ../php/cadastroAdm.html?error=cnpj_existe");
            exit;
        }

        $sql = "INSERT INTO adm (nome, cnpj, email, senha) VALUES (:nome, :cnpj, :email, :senha)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha); 

        $stmt->execute();

        header("Location: ../sessao/adminlog.php?success=cadastro");
        exit;
    } catch (PDOException $e) {
        header("Location: ../php/cadastroAdm.html?error=erro_cadastro");
        exit;
    } catch (Exception $e) {
        header("Location: ../php/cadastroAdm.html?error=erro_generico");
        exit;
    }
}
