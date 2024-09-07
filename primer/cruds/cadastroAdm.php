<?php
require_once 'conexao.php'; 

session_start();

function limpezaInput($input) {
    $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input); 
    return trim($input); 
}

function validarCNPJ($cnpj) {
    $cnpj = preg_replace('/\D/', '', $cnpj);

    if (strlen($cnpj) != 14) {
        return false;
    }

    if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
        return false; 
    }

    $cnpj_base = substr($cnpj, 0, 12);
    $digitos = substr($cnpj, 12, 2);

    $soma = 0;
    $peso = 5;
    for ($i = 0; $i < 12; $i++) {
        $soma += $cnpj_base[$i] * $peso;
        $peso = ($peso == 2) ? 9 : $peso - 1;
    }

    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;

    $soma = 0;
    $peso = 6;
    for ($i = 0; $i < 12; $i++) {
        $soma += $cnpj_base[$i] * $peso;
        $peso = ($peso == 2) ? 9 : $peso - 1;
    }
    $soma += $digito1 * 2;
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;

    return ($digito1 == $digitos[0] && $digito2 == $digitos[1]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = limpezaInput($_POST['nome']);
    $cnpj = limpezaInput($_POST['cnpj']);
    $email = limpezaInput($_POST['email']);
    $senha = limpezaInput($_POST['senha']);

    if (empty($nome) || empty($cnpj) || empty($email) || empty($senha)) {
        $_SESSION['message'] = 'Todos os campos são obrigatórios.';
        header("Location: ../php/cadastroAdm.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = 'O e-mail fornecido não é válido.';
        header("Location: ../php/cadastroAdm.php");
        exit();
    }

    if (!validarCNPJ($cnpj)) {
        $_SESSION['message'] = 'O CNPJ fornecido não é válido.';
        header("Location: ../php/cadastroAdm.php");
        exit();
    }

    try {
        $sql_verificar_cnpj = "SELECT * FROM adm WHERE cnpj = :cnpj";
        $stmt_verificar_cnpj = $pdo->prepare($sql_verificar_cnpj);
        $stmt_verificar_cnpj->bindParam(':cnpj', $cnpj);
        $stmt_verificar_cnpj->execute();

        if ($stmt_verificar_cnpj->rowCount() > 0) {
            $_SESSION['message'] = 'Já existe um administrador com esse CNPJ.';
            header("Location: ../php/cadastroAdm.php");
            exit();
        }

        $sql_verificar_email = "SELECT * FROM adm WHERE email = :email";
        $stmt_verificar_email = $pdo->prepare($sql_verificar_email);
        $stmt_verificar_email->bindParam(':email', $email);
        $stmt_verificar_email->execute();

        if ($stmt_verificar_email->rowCount() > 0) {
            $_SESSION['message'] = 'Já existe um administrador com esse e-mail.';
            header("Location: ../php/cadastroAdm.php");
            exit();
        }

        $sql = "INSERT INTO adm (nome, cnpj, email, senha) VALUES (:nome, :cnpj, :email, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha); 

        $stmt->execute();

        $_SESSION['message'] = 'Administrador cadastrado com sucesso!';
        header("Location: ../sessao/adminlog.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Erro ao cadastrar administrador: ' . $e->getMessage();
        header("Location: ../php/cadastroAdm.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['message'] = 'Ocorreu um erro inesperado: ' . $e->getMessage();
        header("Location: ../php/cadastroAdm.php");
        exit();
    }
}
