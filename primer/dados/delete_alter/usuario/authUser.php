<?php
require_once '../../../cruds/conexao.php';

// Receber os dados do formulário
$id = $_POST['id'];
$novoNome = $_POST['nome'];

// Validar os dados (adicione validação conforme necessário)

// Atualizar o registro na tabela 'marca'
$sql = "UPDATE marca SET nome = :novo_nome WHERE id_marca = :id_marca";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':novo_nome', $novoNome);
$stmt->bindParam(':id_marca', $id);

if ($stmt->execute()) {
    echo "<script>alert('Marca alterada com sucesso!');</script>";
    header('Location: ../../../dados/marcas.php'); // Redirecionar para a página desejada após a alteração
} else {
    echo "Erro ao alterar marca: " . $stmt->errorInfo()[2];
}