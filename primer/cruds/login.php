<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email inválido.') </script>";
        echo "<script>window.location.href = '../php/loginuser.html'</script>";
        exit();
    }

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
            header("Location: ../sessao/sessao.php");
            echo "<script>alert('Login realizado com sucesso. ');</script>";
            exit();
        } else {
            echo "<script>alert('Email ou senha inválido. ');</script>";
            header("Location: ../php/loginuser.html?error=invalid_credentials");
            exit();
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        echo "Erro: " . $e->getMessage();
        header("Location: ../php/loginuser.html?error=server_error");
        exit();
    }
}
