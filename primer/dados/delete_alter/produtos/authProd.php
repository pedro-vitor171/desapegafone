<?php
require_once '../../../cruds/conexao.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function limpezaInput($input) {
        $input = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $input); 
        return trim($input); 
    }

    try {
        $id = limpezaInput($_POST['id']);
        $nome = limpezaInput($_POST['nome']);
        $marca_id = limpezaInput($_POST['marca_id']);
        $geracao = limpezaInput($_POST['geracao']);
        $valor = limpezaInput($_POST['valor']);
        $estoque = limpezaInput($_POST['estoque']);
        
        if (empty($id) || empty($nome) || empty($marca_id) || empty($valor) || empty($estoque)) {
            $_SESSION['message'] = 'Todos os campos são obrigatórios.';
            header('Location: ../../produtos.php');
            exit;
        }

        if ($valor <= 0) {
            $_SESSION['message'] = 'O valor não pode ser negativo.';
            header('Location: ../../produtos.php');
            exit();
        }

        if ($estoque <= 0) {
            $_SESSION['message'] = 'O estoque não pode ser negativo.';
            header('Location: ../../produtos.php');
            exit();
        }

        $sqlCheck = "SELECT COUNT(*) FROM celulares WHERE valor = :valor AND id_celular != :id";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->bindParam(':valor', $valor);
        $stmtCheck->bindParam(':id', $id);
        $stmtCheck->execute();
        $count = $stmtCheck->fetchColumn();

        if ($count > 0) {
            $_SESSION['message'] = 'O valor já está sendo usado por outro celular.';
            header('Location: ../../produtos.php');
            exit();
        }

        $sql = "UPDATE celulares SET nome = :nome, marca_id = :marca_id, geracao = :geracao, valor = :valor, estoque = :estoque WHERE id_celular = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':marca_id', $marca_id);
        $stmt->bindParam(':geracao', $geracao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':estoque', $estoque);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Celular alterado com sucesso!';
            header('Location: ../../../dados/produtos.php');
            exit();
        } else {
            $errorInfo = $stmt->errorInfo();
            $_SESSION['message'] = 'Erro ao alterar celular: ' . $errorInfo[2];
            header('Location: ../../../dados/produtos.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Erro ao alterar celular: ' . $e->getMessage();
        header('Location: ../../../dados/produtos.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'Método de requisição não suportado.';
    header('Location: ../../../dados/produtos.php');
    exit();
}
