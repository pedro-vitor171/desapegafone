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

function validarCNPJ($cnpj) {
    $cnpj = preg_replace('/\D/', '', $cnpj); 

    if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }

    $soma = 0;
    $peso = 5;
    for ($i = 0; $i < 12; $i++) {
        $soma += $cnpj[$i] * $peso;
        $peso = ($peso == 2) ? 9 : $peso - 1;
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;

    $soma = 0;
    $peso = 6;
    for ($i = 0; $i < 13; $i++) {
        $soma += $cnpj[$i] * $peso;
        $peso = ($peso == 2) ? 9 : $peso - 1;
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;

    return ($digito1 == $cnpj[12] && $digito2 == $cnpj[13]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = limpezaInput($_POST['nome']);
    $cnpj = limpezaInput($_POST['cnpj']);
    $telefone = limpezaInput($_POST['telefone']);
    $email = limpezaInput($_POST['email']);
    $endereco = limpezaInput($_POST['endereco']);
    $marca_id = limpezaInput($_POST['marca']);

    if (empty($nome) || empty($cnpj) || empty($telefone) || empty($email) || empty($endereco) || empty($marca_id)) {
        $_SESSION['message'] = "Todos os campos são obrigatórios.";
        header("Location: ../php/cadastroFn.php");
        exit();
    }

    if (!validarEmail($email)) {
        $_SESSION['message'] = "O email fornecido não é válido.";
        header("Location: ../php/cadastroFn.php");
        exit();
    }

    if (!validarCNPJ($cnpj)) {
        $_SESSION['message'] = "O CNPJ fornecido não é válido.";
        header("Location: ../php/cadastroFn.php");
        exit();
    }

    try {
        $sql = "SELECT COUNT(*) FROM fornecedor WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['message'] = "Já existe um fornecedor cadastrado com este email.";
            header("Location: ../php/cadastroFn.php");
            exit();
        }

        $sql = "SELECT COUNT(*) FROM fornecedor WHERE cnpj = :cnpj";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['message'] = "Já existe um fornecedor cadastrado com este CNPJ.";
            header("Location: ../php/cadastroFn.php");
            exit();
        }

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

        $_SESSION['message'] = "Fornecedor cadastrado com sucesso!";
        header("Location: ../php/loginFn.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['message'] = "Erro ao cadastrar fornecedor: " . $e->getMessage();
        header("Location: ../php/cadastroFn.php");
        exit();
    }
}
