<?php
require_once '../cruds/conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cnpj = trim($_POST['cnpj']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM adm WHERE cnpj = :cnpj AND email = :email");
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $adm = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($adm && $senha === $adm['senha']) {
            session_unset();
            session_destroy();

            session_start();
            $_SESSION['id_user'] = $adm['id'];
            $_SESSION['nome'] = $adm['nome'];
            $_SESSION['usuario_tipo'] = "Adm";

            $_SESSION['message'] = 'Login realizado com sucesso!';
            header("Location: ../sessao/admin.php");
            exit;
        } else {
            $_SESSION['message'] = 'CNPJ, email ou senha incorretos.';
            header("Location: ../sessao/adminlog.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Erro: ' . $e->getMessage();
        header("Location: ../sessao/adminlog.php");
        exit;
    }
}
