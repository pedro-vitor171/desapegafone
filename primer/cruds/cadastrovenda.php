<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $produto = $_POST['produto'];
    $comprador = $_POST['comprador'];
    $data = $_POST['data'];
    $valor = $_POST['valor'];

    // Validar os dados antes de inserir
    if (empty($produto) || empty($comprador) || empty($data) || empty($valor)) {
        echo "<script>alert('Todos os campos são obrigatórios.');</script>";
        echo "<script>window.location.href = '../index.html'</script>";
        exit;
    }

    $data_formatada = date('Y-m-d', strtotime($data));

    $sql_verificar = "SELECT * FROM celulares WHERE nome = :produto";
    $stmt_verificar = $pdo->prepare($sql_verificar);
    $stmt_verificar->bindParam(':produto', $produto);
    $stmt_verificar->execute();

    if ($stmt_verificar->rowCount() > 0) {
        $sql = "INSERT INTO venda (produto, comprador, data, valor) VALUES (:produto, :comprador, :data, :valor)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':produto', $produto);
        $stmt->bindParam(':comprador', $comprador);
        $stmt->bindParam(':data', $data_formatada);
        $stmt->bindParam(':valor', $valor);

        try {
            $stmt->execute();
            echo "<script>alert('Venda cadastrada com sucesso!');</script>";
            echo "<script>window.location.href = '../index.html'</script>";
        } catch (PDOException $e) {
            echo "Erro ao inserir a venda: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('O celular informado não existe.');</script>";
        echo "<script>window.location.href = '../index.html'</script>";
    }
}
