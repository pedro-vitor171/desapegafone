<?php
require_once 'conexao.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $cnpj = $_POST['cnpj'];

    if (!$email || !$cnpj) {
        $_SESSION['message'] = 'Todos os campos são obrigatórios.';
        header("Location: ../sessao/loginuser.php");
        exit();
    }

    try {
        $sql = "SELECT * FROM fornecedor WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fornecedor && $cnpj === $fornecedor['cnpj']) {
            session_unset();
            session_destroy();

            session_start();
            $_SESSION['id'] = $fornecedor['id_fornecedor'];
            $_SESSION['nome'] = $fornecedor['nome'];
            $_SESSION['email'] = $fornecedor['email'];
            $_SESSION['cnpj'] = $fornecedor['cnpj'];
            $_SESSION['usuario_tipo'] = 'Fornecedor';

            $_SESSION['message'] = 'Login realizado com sucesso!';
            header("Location: ../sessao/fornecedor.php");
            exit();
        } else {
            $_SESSION['message'] = 'Email ou CNPJ incorretos.';
            header("Location: ../php/loginFn.php");
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['message'] = 'Erro ao realizar login: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        header("Location: ../sessao/loginuser.php");
        exit();
    }
}
