<?php
require_once '../../../cruds/conexao.php';

// Receber os dados do formulário
var_dump($_POST);
$id = $_POST['id'];
$novoNome = $_POST['nome'];
$novoTelefone = $_POST['telefone'];
$novoEmail = $_POST['email'];
$novaSenha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha para segurança

// Validar os dados (adicione validação conforme necessário)

// Atualizar o registro na tabela 'usuarios'
$sql = "UPDATE usuarios SET 
            nome = :novo_nome,
            telefone = :novo_telefone,
            email = :novo_email,
            senha = :nova_senha
        WHERE id_usuario = :id_usuario";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':novo_nome', $novoNome);
$stmt->bindParam(':novo_telefone', $novoTelefone);
$stmt->bindParam(':novo_email', $novoEmail);
$stmt->bindParam(':nova_senha', $novaSenha);
$stmt->bindParam(':id_usuario', $id);

if ($stmt->execute()) {
    echo "<script>alert('Usuário alterado com sucesso!');</script>";
    header('Location: ../../../dados/usuarios.php'); // Redirecionar para a página desejada após a alteração
} else {
    echo "Erro ao alterar usuário: " . $stmt->errorInfo()[2];
}