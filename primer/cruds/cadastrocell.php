<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $geracao = $_POST['geracao'];
    $marca_id = $_POST['marca'];
    $valor = floatval($_POST['valor']); // Garantindo que o valor seja um float

    $sql = "INSERT INTO celulares (nome, marca_id, geracao, valor) VALUES (:nome, :marca_id, :geracao, :valor)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':marca_id', $marca_id, PDO::PARAM_INT);
    $stmt->bindParam(':geracao', $geracao, PDO::PARAM_INT);
    $stmt->bindParam(':valor', $valor, PDO::PARAM_STR); // Ajustado para PDO::PARAM_STR para maior compatibilidade

    try {
        $stmt->execute();
        echo "<script>alert('Celular cadastrado com sucesso!');</script>";
        echo "<script>window.location.href = '../dados/produtos.php'</script>";
    } catch (PDOException $e) {
        echo "Erro ao inserir o celular: " . $e->getMessage();
    }
}