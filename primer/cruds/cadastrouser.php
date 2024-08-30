<?php
require_once 'conexao.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = $_POST['password'];

    $sql = "INSERT INTO usuários (nome, telefone, email, password) VALUES (:nome, :telefone, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $senha);
    $stmt->execute();
    echo "<script>alert('cadastro com sucesso!')</script>";
    echo "<script>window.location.href = '../php/loginuser.html'</script>";
}