<?php
require_once '../cruds/conexao.php';

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
            session_start();
            $_SESSION = array(); 
            session_destroy(); 
            
           
            session_start();
            $_SESSION['id_user'] = $adm['id'];
            $_SESSION['nome'] = $adm['nome'];
            $_SESSION['usuario_tipo'] = "Adm";
            header("Location: ../sessao/admin.php");
            exit;
        } else {
            header("Location: ../sessao/adminlog.php?error=login_incorreto");
            exit;
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}