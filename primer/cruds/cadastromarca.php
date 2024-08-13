<?php
require_once 'conexao.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];

    $sql = "INSERT INTO marca (nome) VALUES (:nome)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->execute();
    echo "<script>alert('cadastro de marca feito com sucesso!')</script>";
    echo "<script>window.location.href = '../index.html'</script>";
}