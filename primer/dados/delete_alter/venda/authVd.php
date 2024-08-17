<?php
require_once '../../../cruds/conexao.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try{
    $id = $_POST['id'];
    $produto = $_POST['produto'];
    $comprador = $_POST['comprador'];
    $data = $_POST['data'];
    $valor = $_POST['valor'];


    $sql = "UPDATE venda SET celular_id = :produto, usuario_id = :comprador, data_venda = :data, valor = :valor WHERE id_venda = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':produto', $produto);
    $stmt->bindParam(':comprador', $comprador);
    $stmt->bindParam(':data', $data);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Venda alterada com sucesso!');</script>";
        header('Location: ../../../dados/vendas.php');
    } else {
        echo "<script>alert('Nenhuma linha foi alterada.')</script>";
        header('Location: ../../../dados/vendas.php');
    }
} catch (PDOException $e) {
    echo "Erro ao alterar venda: " . $e->getMessage();
}
}
