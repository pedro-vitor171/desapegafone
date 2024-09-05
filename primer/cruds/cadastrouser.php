<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $telefone_comprimento_esperado = 11; 

    if (strlen($telefone) !== $telefone_comprimento_esperado || !is_numeric($telefone)) {
        echo "<script>alert('O número de telefone deve ter exatamente $telefone_comprimento_esperado dígitos e conter apenas números.');</script>";
        echo "<script>window.location.href = '../php/cadastrouser.html'</script>";
        exit;
    }

    try {
        $sql_verificar = "SELECT * FROM usuarios WHERE email = :email";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->bindParam(':email', $email);
        $stmt_verificar->execute();

        if ($stmt_verificar->rowCount() > 0) {
            echo "<script>alert('O email informado já existe. Por favor, informe outro email.');</script>";
            echo "<script>window.location.href = '../php/cadastrouser.html'</script>";
            exit;
        }

        $sql = "INSERT INTO usuarios (nome, telefone, email, senha) VALUES (:nome, :telefone, :email, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        echo "<script>alert('Cadastro realizado com sucesso!');</script>";
        echo "<script>window.location.href = '../php/loginuser.html'</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Erro ao cadastrar: " . $e->getMessage() . "');</script>";
        echo "<script>window.location.href = '../php/cadastrouser.html'</script>";
    } catch (Exception $e) {
        echo "<script>alert('" . $e->getMessage() . "');</script>";
        echo "<script>window.location.href = '../php/cadastrouser.html'</script>";
    }
}

