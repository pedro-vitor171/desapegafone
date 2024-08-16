<?php
require_once '../../cruds/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $area = $_POST['area'];

    $sql = '';
    

    if ($area === 'usuarios') {
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
    } elseif ($area === 'marcas') {
        try {
            $pdo->beginTransaction();
    
            // Verificar se existem celulares associados à marca
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM celulares WHERE marca_id = :id_marca");
            $stmt->bindParam(':id_marca', $id);
            $stmt->execute();
            $count = $stmt->fetchColumn();
    
            if ($count > 0) {
                echo '<script>alert("Existem celulares associados a esta marca. Não é possível deletar.");</script>';
                header('location: ../' . $area . '.php');
                exit(); // Não precisa mais redirecionar aqui, a mensagem já foi exibida
            }
    
            // Deletar a marca
            $stmt = $pdo->prepare("DELETE FROM marca WHERE id_marca = :id_marca");
            $stmt->bindParam(':id_marca', $id);
            $stmt->execute();
    
            $pdo->commit();
            echo '<script>alert("Marca excluída com sucesso!");</script>';
            header('location: ../' . $area . '.php');
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo 'Erro ao deletar marca: ' . $e->getMessage();
            // Adicionar um log ou notificação para o administrador aqui, se necessário
        } catch (Exception $e) {
            $pdo->rollBack();
            echo 'Erro inesperado: ' . $e->getMessage();
            // Adicionar um log ou notificação para o administrador aqui, se necessário
        }
    } elseif ($area === 'produtos') {
        // Verificar se existem vendas associadas ao produto
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM venda WHERE celular_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        if ($count > 0) {
            echo '<script>alert("Existem vendas associadas ao produto. Não é possível deletar.")</script>';
            header('location: ../' . $area . '.php');
            exit();
        }
    
        // Corrigindo a consulta e o bindParam
        $sql = "DELETE FROM celulares WHERE id_celular = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    }elseif ($area === 'vendas') {
        $sql = "DELETE FROM venda WHERE id_venda = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        try {
            $pdo->beginTransaction();
            $stmt->execute();
            $affectedRows = $stmt->rowCount(); // Verifica se alguma linha foi afetada
    
            if ($affectedRows > 0) {
                $pdo->commit();
                echo '<script>alert("Registro excluído com sucesso!");</script>';
                header('Location: ../' . $area . '.php');
            } else {
                echo '<script>alert("Não foi encontrado nenhum registro para excluir.");</script>';
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo 'Erro ao deletar registro: ' . $e->getMessage();
            // Adicionar log ou notificação para o administrador aqui
        }
    }
