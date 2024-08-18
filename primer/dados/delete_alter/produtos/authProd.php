<?php
require_once '../../../cruds/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $marca_id = $_POST['marca_id'];
        $geracao = $_POST['geracao'];
        $valor = $_POST['valor'];

        // Atualiza a tabela celulares
        $sql = "UPDATE celulares SET nome = :nome, marca_id = :marca_id, geracao = :geracao, valor = :valor WHERE id_celular = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':marca_id', $marca_id);
        $stmt->bindParam(':geracao', $geracao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo "<script>alert('Celular alterado com sucesso!');</script>";
            header('Location: ../../../dados/produtos.php'); // Ajustar o local de redirecionamento
        } else {
            echo "<script>alert('Nenhuma linha foi alterada.')</script>";
            header('Location: ../../../dados/produtos.php');
        }
    } catch (PDOException $e) {
        echo "Erro ao alterar celular: " . $e->getMessage();
    }
}