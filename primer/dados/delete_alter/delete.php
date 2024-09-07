<?php
require_once '../../cruds/conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $area = isset($_POST['area']) ? trim($_POST['area']) : '';

    try {
        if ($area === 'usuarios') {
            $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); 

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Usuário excluído com sucesso!';
            } else {
                $_SESSION['message'] = 'Erro ao excluir usuário: ' . $stmt->errorInfo()[2];
            }
        } elseif ($area === 'marcas') {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM venda WHERE celular_id IN (SELECT id_celular FROM celulares WHERE marca_id = :id_marca)");
            $stmt->bindParam(':id_marca', $id);
            $stmt->execute();
            $numVendas = $stmt->fetchColumn();

            if ($numVendas > 0) {
                $_SESSION['message'] = "Não é possível excluir a marca. Existem vendas associadas aos celulares desta marca.";
                $pdo->rollBack(); 
            } else {
                $stmt = $pdo->prepare("SELECT id_celular FROM celulares WHERE marca_id = :id_marca");
                $stmt->bindParam(':id_marca', $id);
                $stmt->execute();
                $celulares = $stmt->fetchAll(PDO::FETCH_COLUMN);

                foreach ($celulares as $celularId) {
                    $stmt = $pdo->prepare("DELETE FROM celulares WHERE id_celular = :id_celular");
                    $stmt->bindParam(':id_celular', $celularId);
                    $stmt->execute();
                }

                $stmt = $pdo->prepare("DELETE FROM marcas WHERE id_marca = :id_marca");
                $stmt->bindParam(':id_marca', $id);
                $stmt->execute();

                $pdo->commit();
                $_SESSION['message'] = "Marca e celulares associados excluídos com sucesso!";
            }
        } elseif ($area === 'produtos') {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM venda WHERE celular_id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $_SESSION['message'] = "Não é possível excluir o produto. Ele está associado a uma ou mais vendas.";
            } else {
                $sql = "DELETE FROM celulares WHERE id_celular = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                if ($stmt->execute()) {
                    $_SESSION['message'] = "Produto deletado com sucesso!";
                } else {
                    $_SESSION['message'] = "Erro ao deletar o produto: " . $stmt->errorInfo()[2];
                }
            }
        }

        header('Location: ../' . $area . '.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erro de conexão: " . $e->getMessage();
        header('Location: ../' . $area . '.php');
        exit();
    }
}
