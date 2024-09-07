<?php
require_once 'conexao.php';

session_start();

function limpezaInput($input) {
    $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input);
    return trim($input); 
}

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = limpezaInput($_POST['nome']);
    $telefone = limpezaInput($_POST['telefone']);
    $email = limpezaInput($_POST['email']);
    $senha = limpezaInput($_POST['senha']);

    $telefone_comprimento_esperado = 11; 

    // Verificar comprimento e formato do telefone
    if (strlen($telefone) !== $telefone_comprimento_esperado || !is_numeric($telefone)) {
        $_SESSION['message'] = 'O número de telefone deve ter exatamente ' . $telefone_comprimento_esperado . ' dígitos e conter apenas números.';
        header('Location: ../php/cadastrouser.php');
        exit();
    }

    // Verificar formato do email
    if (!validarEmail($email)) {
        $_SESSION['message'] = 'O email fornecido não é válido.';
        header('Location: ../php/cadastrouser.php');
        exit();
    }

    try {
        $sql_verificar = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->bindParam(':email', $email);
        $stmt_verificar->execute();
        $email_existe = $stmt_verificar->fetchColumn();

        if ($email_existe > 0) {
            $_SESSION['message'] = 'O email informado já existe. Por favor, informe outro email.';
            header('Location: ../php/cadastrouser.php');
            exit();
        }

        $sql = "INSERT INTO usuarios (nome, telefone, email, senha) VALUES (:nome, :telefone, :email, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        $_SESSION['message'] = 'Cadastro realizado com sucesso!';
        header('Location: ../php/loginuser.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Erro ao cadastrar: ' . $e->getMessage();
        header('Location: ../php/cadastrouser.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['message'] = 'Erro inesperado: ' . $e->getMessage();
        header('Location: ../php/cadastrouser.php');
        exit();
    }
}
