<?php
require_once '../../cruds/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $area = $_POST['area'];

    $sql = '';
    

    if ($area === 'usuarios') {
        try {        
            $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        
            if ($stmt->execute()) {
                echo "<script>alert('Registro excluído com sucesso!')<script>";
                header('location: ../' . $area . '.php');
            } else {
                echo "Erro ao excluir registro: " . $stmt->errorInfo()[2];
                header('location: ../' . $area . '.php');
            }
        } catch (PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
        }
    } elseif ($area === 'marcas') {
        try {
            $pdo->beginTransaction();
    
            // Verificar se existem vendas para os celulares da marca
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM venda WHERE celular_id IN (SELECT id_celular FROM celulares WHERE marca_id = :id_marca)");
            $stmt->bindParam(':id_marca', $id);
            $stmt->execute();
            $numVendas = $stmt->fetchColumn();
    
            if ($numVendas > 0) {
                echo '<script>alert("Não é possível excluir a marca. Existem vendas associadas aos celulares desta marca.");</script>';
            } else {
                // Se não houver vendas, prosseguir com a exclusão
                $stmt = $pdo->prepare("SELECT id_celular FROM celulares WHERE marca_id = :id_marca");
                $stmt->bindParam(':id_marca', $id);
                $stmt->execute();
                $celulares = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
                foreach ($celulares as $celularId) {
                    $stmt = $pdo->prepare("DELETE FROM celulares WHERE id_celular = :id_celular");
                    $stmt->bindParam(':id_celular', $celularId);
                    $stmt->execute();
                }
    
                $stmt = $pdo->prepare("DELETE FROM marca WHERE id_marca = :id_marca");
                $stmt->bindParam(':id_marca', $id);
                $stmt->execute();
    
                $pdo->commit();
                echo '<script>alert("Marca e celulares associados excluídos com sucesso!");</script>';
            }
    
            header('location: ../' . $area . '.php');
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo 'Erro ao deletar marca: ' . $e->getMessage();
        } catch (Exception $e) {
            $pdo->rollBack();
            echo 'Erro inesperado: ' . $e->getMessage();
        }
    } elseif ($area === 'produtos') {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM venda WHERE celular_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        if ($count > 0) {
            $sql = "DELETE FROM venda WHERE celular_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            if (!$stmt->execute()) {
                die("Erro ao deletar as vendas: " . $stmt->errorInfo()[2]);
            }
        }
    
        // Deletar o produto
        $sql = "DELETE FROM celulares WHERE id_celular = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            echo '<script>alert("Produto deletado com sucesso!");</script>';
            header('location: ../' . $area . '.php');
            exit();
        } else {
            echo '<script>alert("Erro ao deletar o produto: ' . $stmt->errorInfo()[2] . "</script>";
        }
    }
    } 
