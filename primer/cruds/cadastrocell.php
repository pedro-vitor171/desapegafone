<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $geracao = $_POST['geracao'];
    $marca = $_POST['marca'];
    $valor = $_POST['valor'];

    $sql_verificar_marca = "SELECT * FROM marca WHERE nome = :marca";
    $stmt_verificar = $pdo->prepare($sql_verificar_marca);
    $stmt_verificar->bindParam(':marca', $marca);
    $stmt_verificar->execute();

    if ($stmt_verificar->rowCount() > 0) {
         $sql = "INSERT INTO celulares (nome, marca, geração, valor) VALUES (:nome, :marca, :geracao, :valor)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':geracao', $geracao);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':valor', $valor);
        $stmt->execute();

        echo "<script>alert('Celular cadastrado com sucesso!');</script>";
        echo "<script>window.location.href = '../index.html'</script>";
    } else {
        echo "<script>alert('A marca informada não existe. Por favor, cadastre a marca primeiro.');</script>";
        echo "<script>window.location.href = '../index.html'</script>";
    }
}
