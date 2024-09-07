<?php
require_once '../../../cruds/conexao.php';
session_start();

function limpezaInput($input) {
    $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input); 
    return trim($input); 
}

$page = limpezaInput($_POST['page']);
$id = limpezaInput($_POST['id']);
$novoNome = limpezaInput($_POST['nome']);
$novoTelefone = limpezaInput($_POST['telefone']);
$novoEmail = limpezaInput($_POST['email']);
$novaSenha = limpezaInput($_POST['senha']); 

if (empty($id) || empty($novoNome) || empty($novoTelefone) || empty($novoEmail) || empty($novaSenha)) {
    $_SESSION['message'] = 'Todos os campos são obrigatórios.';
    header('Location: ../../../sessao/' . $page . '.php');
    exit();
}

try {
    $sql_verificar = "SELECT COUNT(*) FROM usuarios WHERE (email = :email OR telefone = :telefone OR nome = :nome) AND id_usuario != :id_usuario";
    $stmt_verificar = $pdo->prepare($sql_verificar);
    $stmt_verificar->bindParam(':email', $novoEmail);
    $stmt_verificar->bindParam(':telefone', $novoTelefone);
    $stmt_verificar->bindParam(':nome', $novoNome);
    $stmt_verificar->bindParam(':id_usuario', $id);
    $stmt_verificar->execute();
    $count = $stmt_verificar->fetchColumn();

    if ($count > 0) {
        $_SESSION['message'] = 'Alguns dos dados já estão cadastrados em outro usuário.';
        header('Location: ../../../sessao/' . $page . '.php');
        exit();
    }

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
        $_SESSION['id_user'] = $id; 
        $_SESSION['usuario_tipo'] = 'Usuario';
        $_SESSION['nome'] = $novoNome;
        $_SESSION['telefone'] = $novoTelefone;
        $_SESSION['email'] = $novoEmail;
        $_SESSION['senha'] = $novaSenha;
        
        $_SESSION['message'] = 'Usuário alterado com sucesso!';
    } else {
        $_SESSION['message'] = "Erro ao alterar usuário: " . $stmt->errorInfo()[2];
    }
    
    // Redirecionar com base na página
    if ($page === 'sessao') {
        header('Location: ../../../sessao/' . $page . '.php');
    } elseif ($page === 'usuarios') {
        header('Location: ../../../dados/' . $page . '.php');
    }
    exit();
} catch (PDOException $e) {
    $_SESSION['message'] = 'Erro ao atualizar dados: ' . $e->getMessage();
    if ($page === 'sessao') {
        header('Location: ../../../sessao/' . $page . '.php');
    } elseif ($page === 'usuarios') {
        header('Location: ../../../dados/' . $page . '.php');
    }
    exit();
}
