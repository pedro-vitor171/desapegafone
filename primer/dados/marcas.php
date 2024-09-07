<?php
require_once '../cruds/conexao.php';
session_start();
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);
}
$sql = "SELECT * FROM marca ORDER BY id_marca ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "
    SELECT 
        m.id_marca, 
        m.nome, 
        COUNT(DISTINCT f.id_fornecedor) AS num_fornecedores, 
        COUNT(c.id_celular) AS num_celulares
    FROM marca m
    LEFT JOIN fornecedor f ON m.id_marca = f.marca_id
    LEFT JOIN celulares c ON m.id_marca = c.marca_id
    GROUP BY m.id_marca
    ORDER BY m.id_marca ASC
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/dados.css">
    <link rel="shortcut icon" href="../css/imgs/arch.svg" type="image/x-icon">
    <title>PrimerPhone</title>
    <style>
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .Inform {
            width: 65%;
            margin: 5dvh 0;
            text-align: center;
            padding: 3.6dvh;
            font-size: .6dvh;
        }

        table {
            width: 110%;
            border-collapse: collapse;
            text-align: center;
        }

        .deletar, .alterar {
            cursor: pointer;
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
            <h1>Marcas</h1>
            <table id="customers">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>N° Fornecedores</th>
                    <th>N° Produtos</th>
                    <th>Deletar</th>
                    <th>Alterar</th>
                </tr>
                <?php foreach ($marcas as $marca) { ?>
                    <tr>
                        <td><?php echo $marca['id_marca']; ?></td>
                        <td><?php echo $marca['nome']; ?></td>
                        <td><?php echo $marca['num_fornecedores']; ?></td>
                        <td><?php echo $marca['num_celulares']; ?></td>
                        <td>
                            <form method="post" action="delete_alter/delete.php">
                                <input type="hidden" name="id" value="<?= $marca['id_marca']; ?>">
                                <input type="hidden" name="area" value="marcas">
                                <button type="submit" class="deletar"
                                    onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="delete_alter/marca/alterMarca.php">
                                <input type="hidden" name="id" value="<?= $marca['id_marca']; ?>">
                                <input type="hidden" name="area" value="marcas">
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