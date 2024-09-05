<?php
require_once '../../../cruds/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $marca_id = $_POST['marca_id'];
        $geracao = $_POST['geracao'];
        $valor = $_POST['valor'];
        $estoque = $_POST['estoque'];

        if ($valor < 0) {
            echo "<script>alert('O valor não pode ser negativo.');</script>";
            header('location: ../../produtos.php');
            exit();
        }
    
        if ($estoque < 0) {
            echo "<script>alert('O estoque não pode ser negativo.');</script>";
            header('location: ../../produtos.php');
            exit();
        }

        $sql = "UPDATE celulares SET nome = :nome, marca_id = :marca_id, geracao = :geracao, valor = :valor, estoque = :estoque WHERE id_celular = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':marca_id', $marca_id);
        $stmt->bindParam(':geracao', $geracao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':estoque', $estoque);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo "<script>alert('Celular alterado com sucesso!');</script>";
            header('Location: ../../../dados/produtos.php');
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Erro ao alterar celular: " . $errorInfo[2];
        }
    } catch (PDOException $e) {
        echo "Erro ao alterar celular: " . $e->getMessage();
    }
}