<?php
require_once '../../../cruds/conexao.php';
session_start();
function limpezaInput($input) {
    $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input);
    return trim($input); 
}

$id = limpezaInput($_POST['id']);
$novoNome = limpezaInput($_POST['nome']);

if (empty($id) || empty($novoNome)) {
    $_SESSION['message'] = "Todos os campos são obrigatórios.";
    header('Location: ../../../dados/marcas.php');
    exit;
}

$sql_verificar = "SELECT COUNT(*) FROM marca WHERE nome = :novo_nome AND id_marca <> :id_marca";
$stmt_verificar = $pdo->prepare($sql_verificar);
$stmt_verificar->bindParam(':novo_nome', $novoNome);
$stmt_verificar->bindParam(':id_marca', $id);
$stmt_verificar->execute();
$nome_existe = $stmt_verificar->fetchColumn();

if ($nome_existe > 0) {
    $_SESSION['message'] = "Já existe uma marca com o nome informado.";
    header('Location: ../../../dados/marcas.php');
    exit;
}

$sql = "UPDATE marca SET nome = :novo_nome WHERE id_marca = :id_marca";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':novo_nome', $novoNome);
$stmt->bindParam(':id_marca', $id);

if ($stmt->execute()) {
    $_SESSION['message'] = "Marca alterada com sucesso!";
    header('Location: ../../../dados/marcas.php');
    exit;
} else {
    $_SESSION['message'] = "Erro ao alterar marca: " . $stmt->errorInfo()[2];
    header('Location: ../../../dados/marcas.php');
    exit;
}
