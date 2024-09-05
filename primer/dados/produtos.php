<?php
require_once '../cruds/conexao.php';
$sql = "
    SELECT celulares.*, fornecedor.nome AS fornecedor_nome
    FROM celulares
    LEFT JOIN fornecedor ON celulares.fornecedor_id = fornecedor.id_fornecedor
    ORDER BY celulares.id_celular DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$celulares = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            width: 60%;
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
        <div class="Inform">
            <h1>Celulares</h1>
            <table id="customers">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Fornecedor</th>
                    <th>Marca</th>
                    <th>Geração</th>
                    <th>Estoque</th>
                    <th>Preço</th>
                    <th>Deletar</th>
                    <th>Alterar</th>
                </tr>
                <?php foreach ($celulares as $celular) { ?>
                    <tr>
                        <td><?php echo $celular['id_celular']; ?></td>
                        <td><?php echo $celular['nome']; ?></td>
                        <td>
                            <?php
                            echo $celular['fornecedor_nome'] ? $celular['fornecedor_nome'] : 'Freelancer';
                            ?>
                        </td>
                        <td>
                            <?php
                            $sql_marca = "SELECT nome FROM marca WHERE id_marca = :marca_id";
                            $stmt_marca = $pdo->prepare($sql_marca);
                            $stmt_marca->bindParam(':marca_id', $celular['marca_id']);
                            $stmt_marca->execute();
                            $marca = $stmt_marca->fetch(PDO::FETCH_ASSOC);
                            echo $marca['nome'];
                            ?>
                        </td>
                        <td><?php echo $celular['geracao']; ?></td>
                        <td><?php echo $celular['estoque'] ?></td>
                        <td><?= "R$ " . number_format($celular['valor'], 2, ',', '.'); ?></td>
                        <td>
                            <form method="post" action="delete_alter/delete.php">
                                <input type="hidden" name="id" value="<?= $celular['id_celular']; ?>">
                                <input type="hidden" name="page" value="produtos">
                                <input type="hidden" name="area" value="produtos">
                                <button type="submit" class="deletar"
                                    onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="delete_alter/produtos/alterProd.php">
                                <input type="hidden" name="id" value="<?= $celular['id_celular']; ?>">
                                <input type="hidden" name="page" value="produtos">
                                <input type="hidden" name="area" value="produtos">
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
            <p>Numero de telefone: 77 95590-3454</p>
            <p>E-mail: PrimerPhone@gmail.com</p>
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