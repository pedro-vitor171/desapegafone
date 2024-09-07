<?php
require_once '../../cruds/conexao.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $area = $_POST['area'];

    if ($area === 'administradores') {
        try {
            $sql = "DELETE FROM adm WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Adm excluído com sucesso!';
            } else {
                $_SESSION['message'] = 'Erro ao excluir adm: ' . $stmt->errorInfo()[2];
            }

            header('Location: ../' . $area . '.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Erro de conexão: ' . $e->getMessage();
            header('Location: ../' . $area . '.php');
            exit();
        }
    }
}
