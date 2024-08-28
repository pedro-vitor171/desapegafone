<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        session_start();
        $_SESSION['id_user'] = $user['id_usuario']; // Set session ID from user data
        $_SESSION['email'] = $user['email'];
        $_SESSION['nome'] = $user['nome'];

        echo "<script>alert('Login realizado com sucesso.') </script>";
        echo "<script>window.location.href = '../sessao/sessao.php'</script>";
    } else {
        echo "<script>alert('Email ou senha inválidos.') </script>";
        echo "<script>window.location.href = '../php/loginuser.html'</script>";
    }
}