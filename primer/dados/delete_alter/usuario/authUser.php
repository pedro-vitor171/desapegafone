<?php
require_once '../../../cruds/conexao.php';

$page = $_POST['page'];
$id = $_POST['id'];
$novoNome = $_POST['nome'];
$novoTelefone = $_POST['telefone'];
$novoEmail = $_POST['email'];
$novaSenha = $_POST['senha']; 
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
    session_start();
    $_SESSION['id_user'] = $id; 
    $_SESSION['usuario_tipo'] = 'Usuario';
    $_SESSION['nome'] = $novoNome;
    $_SESSION['telefone'] = $novoTelefone;
    $_SESSION['email'] = $novoEmail;
    $_SESSION['senha'] = $novaSenha;
    echo "<script>alert('Usuário alterado com sucesso!');</script>";
    if($page = 'sessao'){
    header('Location: ../../../sessao/'.$page.'.php');
    } elseif($page = 'usuarios'){
        header('Location: ../../../dados/'.$page.'.php');
    }
} else {
    echo "Erro ao alterar usuário: " . $stmt->errorInfo()[2];
}