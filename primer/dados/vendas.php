<?php
require_once '../cruds/conexao.php';
$sql = "SELECT * FROM venda ORDER BY id_venda DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        td .deletar {
            cursor: pointer;
            all: inherit;
            background: #d81f1f;
            color: #ffffff;
            font-size: 2.6dvh;
            padding: .5dvh;
            border-radius: 5px;
        }
        td .alterar {
            cursor: pointer;
            all: inherit;
            background: #1870d5;
            color: #ffffff;
            padding: .5dvh;
            border-radius: 5px;
            font-size: 2.6dvh;
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
        <a href="../php/cadastrouser.html">Cadastro</a>
        <a href="../php/loginuser.html">Login</a>
    </div>

    <main>
        <table id="customers">
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Comprador</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Deletar</th>
                <th>Alterar</th>
            </tr>
            <?php foreach ($usuarios as $row) { ?>
    <tr>
        <td><?= $row['id_venda']; ?></td>
        <td>
            <?php
            $sql_celular = "SELECT nome FROM celulares WHERE id_celular = :celular_id";
            $stmt_celular = $pdo->prepare($sql_celular);
            $stmt_celular->bindParam(':celular_id', $row['celular_id']);

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
            $stmt_usuario->bindParam(':usuario_id', $row['usuario_id']);

            if ($stmt_usuario->execute()) {
                $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
                echo $usuario['nome'] ?? "Usuário não encontrado";
            } else {
                echo "Erro ao buscar usuário: " . $stmt_usuario->errorInfo()[2];
            }
            ?>
        </td>
        <td><?= $row['data_venda']; ?></td>
        <td><?= $row['valor']." R$"; ?></td>
        <td>
            <form method="post" action="delete_alter/deleteVd.php">
                <input type="hidden" name="id" value="<?= $row['id_venda']; ?>">
                <input type="hidden" name="area" value="vendas">
                <button type="submit" class="deletar" onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</button>
            </form>
        </td>
        <td>
            <form method="post" action="delete_alter/venda/alterVd.php">
                <input type="hidden" name="id" value="<?= $row['id_venda']; ?>">
                <input type="hidden" name="area" value="vendas">
                <button type="submit" class="alterar" onclick="return confirm('Tem certeza que deseja alterar?');">Alterar</button>
            </form>
        </td>
    </tr>
<?php } ?>
        </table>
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
                <p>Numero de telefone: 77 95590-3454</p>
                <p>E-mail: PrimerPhone@gmail.com</p>
                <p><a href="../sessao/adminlog.php">Adminlog</a></p>
                <p><a href="../sessao/admin.php">Admins</a></p>            </div>
            <div class="names">
                <h2>Redes Sociais:</h2>
                <p>- Github</p>
                <p>- Instagram</p>
                <p>- Twitter</p>
            </div>
            </div>
        </footer>
</body>

</html>