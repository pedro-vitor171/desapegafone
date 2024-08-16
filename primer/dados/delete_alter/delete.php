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
                throw new Exception("Existem celulares associados à marca. Não é possível deletar.");
            }

            // Deletar a marca
            $stmt = $pdo->prepare("DELETE FROM marca WHERE id_marca = :id_marca");
            $stmt->bindParam(':id_marca', $id);
            $stmt->execute();

            $pdo->commit();
        } catch (PDOException | Exception $e) {
            $pdo->rollBack();
            echo 'Erro ao deletar marca: ' . $e->getMessage();
            exit();
        }
    } elseif ($area === 'produtos') {
        // Verificar se existem vendas associadas ao produto
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM venda WHERE celular_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        if ($count > 0) {
            echo '<script>alert("Existem vendas associadas ao produto. Não é possível deletar.")</script>';
            exit();
        }
    
        // Corrigindo a consulta e o bindParam
        $sql = "DELETE FROM celulares WHERE id_celular = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    } elseif ($area === 'vendas') {
        $sql = "DELETE FROM venda WHERE id_venda = :id";
    } else {
        echo '<script>alert("Erro ao deletar registro.")</script>';
        exit();
    }
    
    if (empty($sql)) {
        echo 'Consulta SQL inválida.';
        exit();
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        header('Location: ../' . $area . '.php');
        exit();
    } catch (PDOException $e) {
        echo 'Erro ao deletar registro: ' . $e->getMessage();
    }
