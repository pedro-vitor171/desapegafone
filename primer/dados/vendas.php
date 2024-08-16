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
        td button {
            cursor: pointer;
            all: inherit;
            background: #d81f1f;
            color: #000000;
            font-size: 2.5dvh;
        }
    </style>
</head>

<body>


    <div class="subnav">
        <a href="../sessao/sessao.php">Conta</a>
        <a href="">Sobre</a>
        <div class="log">
            <h1><b><a href="../index.html">PrimerPhone</a></b></h1>
        </div>
        <a href="php/cadastrouser.html">Cadastro</a>
        <a href="php/loginuser.html">Login</a>
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
            </tr>
            <?php foreach ($usuarios as $row) { ?>
                <tr>
                    <td><?php echo $row['id_venda'];?></td>
                    <td>
                    <?php
                            $sql_celular = "SELECT nome FROM celulares WHERE id_celular = :celular_id";
                            $stmt_celular = $pdo->prepare($sql_celular);
                            $stmt_celular->bindParam(':celular_id', $row['celular_id']);
                            $stmt_celular->execute();
                            $celular = $stmt_celular->fetch(PDO::FETCH_ASSOC);
                            echo $celular['nome'];
                        ?> 
                        </td>                   
                        <td>
                        <?php
                            $sql_usuario = "SELECT nome FROM usuarios WHERE id_usuario = :usuario_id";
                            $stmt_usuario = $pdo->prepare($sql_usuario);
                            $stmt_usuario->bindParam(':usuario_id', $row['usuario_id']);
                            $stmt_usuario->execute();
                            $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
                            echo $usuario['nome'];
                        ?>
                        </td>
                    <td><?php echo $row['data_venda']; ?></td>
                    <td><?php echo $row['valor']; ?></td>
                    <td>
                    <form method="post" action="delete_alter/delete.php">
                        <input type="hidden" name="id" value="<?php echo $row['id_venda']; ?>">
                        <input type="hidden" name="area" value="vendas"> <button type="submit" onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</button>
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
                <p>E-mail: sentarebolando@gmail.com</p>
            </div>
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