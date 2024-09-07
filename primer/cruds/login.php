<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email =$_POST['email'];
    $senha = $_POST['senha'];

    try {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $senha === $user['senha']) {
            session_start();
            $_SESSION = array(); 
            session_destroy(); 

            session_start(); 
            $_SESSION['id_user'] = $user['id_usuario'];
            $_SESSION['usuario_tipo'] = 'Usuario';
            $_SESSION['telefone'] = $user['telefone'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['senha'] = $user['senha'];
            
            $_SESSION['message'] = "Login realizado com sucesso.";
            header("Location: ../sessao/sessao.php");
            exit();
        } else {
            session_start();
            $_SESSION['message'] = "Email ou senha inválido.";
            header("Location: ../php/loginuser.php");
            exit();
        }
    } catch (PDOException $e) {
        session_start();
        $_SESSION['message'] = "Erro ao realizar login: " . $e->getMessage();
        error_log($e->getMessage());
        header("Location: ../php/loginuser.php");
        exit();
    }
}
