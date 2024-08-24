<?php
require_once '../cruds/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cnpj = $_POST['cnpj'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM adm WHERE cnpj = :cnpj AND email = :email AND senha = :senha");
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            session_start();
            $_SESSION['nome'] = $result['nome'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['cnpj'] = $result['cnpj'];
            $_SESSION['senha'] = $result['senha'];

            echo "<script>window.location.href = '../sessao/admin.php';</script>";
            echo "<script>alert('Login realizado com sucesso.');</script>";
        } else {
            // Login failed
            echo "<script>window.location.href = '../sessao/adminlog.php';</script>";
            echo "<script>alert('Dados de login incorretos.');</script>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
