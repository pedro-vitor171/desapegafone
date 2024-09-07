<?php
require_once '../cruds/conexao.php';
session_start();
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);
}
$sql = "SELECT * FROM venda ORDER BY id_venda DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Usuario') {
    header("Location: ../sessao/sessao.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="shortcut icon" href="../css/imgs/arch.svg" type="image/x-icon">
    <link rel="stylesheet" href="../css/dados.css">
    <title>PrimerPhone</title>
    <style>
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .Inform {
            width: 85%;
            margin-top: 5dvh;
            margin-bottom: 5dvh;
        }
    </style>
</head>

<body>
    <div class="subnav">
        <a href="../sessao/sessao.php">Conta</a>
        <a href="../sessao/user.php">Inicio</a>
        <div class="log">
            <h1><b><a href="../index.html">PrimerPhone</a></b></h1>
        </div>
        <a href="../php/cadastrouser.php">Cadastro</a>
        <a href="../php/loginuser.php">Login</a>
    </div>

    <main>
        <div class="Inform">
            <h1>Vendas</h1>
            <table id="customers">
                <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Comprador</th>
                    <th>Data</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                    <th>Deletar</th>
                    <th>Alterar</th>
                </tr>

                <?php foreach ($vendas as $venda) {
                    $data_venda_formatada = (new DateTime($venda["data_venda"]))->format('d/m/Y');
                    ?>
                    <tr>
                        <td><?= $venda['id_venda']; ?></td>
                        <td>
                            <?php
                            $sql_celular = "SELECT nome FROM celulares WHERE id_celular = :celular_id";
                            $stmt_celular = $pdo->prepare($sql_celular);
                            $stmt_celular->bindParam(':celular_id', $venda['celular_id']);

                            if ($stmt_celular->execute()) {
                                $celular = $stmt_celular->fetch(PDO::FETCH_ASSOC);
                                echo $celular['nome'] ?? "Produto não encontrado";
                            } else {
                                echo "Erro ao buscar produto: " . $stmt_celular->errorInfo()[2];
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $sql_usuario = "SELECT nome FROM usuarios WHERE id_usuario = :usuario_id";
                            $stmt_usuario = $pdo->prepare($sql_usuario);
                            $stmt_usuario->bindParam(':usuario_id', $venda['usuario_id']);

                            if ($stmt_usuario->execute()) {
                                $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
                                echo $usuario['nome'] ?? "Usuário não encontrado";
                            } else {
                                echo "Erro ao buscar usuário: " . $stmt_usuario->errorInfo()[2];
                            }
                            ?>
                        </td>
                        <td><?= $data_venda_formatada; ?></td>
                        <td><?= $venda['quantidade']; ?></td>
                        <td><?= isset($venda['valor']) ? "R$ ". number_format($venda['valor'], '2', ',', '.'): 'Valor não informado'; ?></td>
                        <td>
                            <form method="post" action="delete_alter/deleteVd.php">
                                <input type="hidden" name="id" value="<?= $venda['id_venda']; ?>">
                                <input type="hidden" name="area" value="vendas">
                                <button type="submit" class="deletar"
                                    onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="delete_alter/venda/alterVd.php">
                                <input type="hidden" name="id" value="<?= $venda['id_venda']; ?>">
                                <input type="hidden" name="area" value="vendas">
                                <button type="submit" class="alterar"
                                    onclick="return confirm('Tem certeza que deseja alterar?');">Alterar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </main>

    <footer>
        <div class="names">
            <h2>Desenvolvedores:</h2>
            <p>Breno Lacerda</p>
            <p>Pedro Vitor</p>
            <p>Pedro Guimel</p>
        </div>
        <div class="names">
            <h2>Contatos:</h2>
            <p>Número de telefone: 77 95590-3454</p>
            <p>E-mail: PrimerPhone@gmail.com</p>
        </div>
        <div class="names">
            <h2>Redes Sociais:</h2>
            <p>- Github</p>
            <p>- Instagram</p>
            <p>- Twitter</p>
        </div>
    </footer>
</body>

</html>