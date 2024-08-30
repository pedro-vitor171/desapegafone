<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuários WHERE email = :email AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        session_start();
        $_SESSION['email'] = $user['email'];
        echo "<script>alert('Login realizado com sucesso.')</script>";
        echo "<script>window.location.href = '../sessao/sessao.php'</script>";
    } else {
        echo "<script>alert('Email ou senha inválidos.')</script>";
        echo "<script>window.location.href = '../php/loginuser.html'</script>";
    }
}
