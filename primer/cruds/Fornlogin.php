<?php
require_once 'conexao.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $cnpj = trim($_POST['cnpj']);

    if (!$email || !$cnpj) {
        echo "<script>alert('Todos os campos são obrigatórios.');</script>";
        echo "<script>window.location.href = '../sessao/loginuser.html';</script>";
        exit();
    }

    try {
        $sql = "SELECT * FROM fornecedor WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fornecedor && $cnpj === $fornecedor['cnpj']) {
            session_start();
            $_SESSION = array();
            session_destroy();

            session_start();
            $_SESSION['id'] = $fornecedor['id_fornecedor'];
            $_SESSION['nome'] = $fornecedor['nome'];
            $_SESSION['email'] = $fornecedor['email'];
            $_SESSION['cnpj'] = $fornecedor['cnpj'];
            $_SESSION['usuario_tipo'] = 'Fornecedor';
            header("Location: ../sessao/fornecedor.php");
            exit();
        } else {
            echo "<script>alert('Email ou senha incorretos.');</script>";
            echo "<script>window.location.href = '../php/loginFn.php';</script>";
            exit();
        }

    } catch (PDOException $e) {
        echo "<script>alert('Erro ao realizar login: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "');</script>";
        echo "<script>window.location.href = '../sessao/loginuser.html';</script>";
        exit();
    }
}
