<?php
session_start();
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script>window.location.href ='../php/loginuser.html'</script>";
    echo "alert('Por favor, realize o login.')";
}
if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Adm') {
    header("Location: admin.php");
    echo "<script>alert('Por favor, realize o login.')</script>";
    exit();
}
if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Fornecedor') {
    header("Location: fornecedor.php");
    echo "<script>alert('Por favor, realize o login.')</script>";
    exit();
}
$login = $_SESSION['email'];
require_once '../cruds/conexao.php';

$sql = "SELECT v.*, c.nome AS celular_nome, u.nome AS usuario_nome
        FROM venda v
        INNER JOIN celulares c ON v.celular_id = c.id_celular
        INNER JOIN usuarios u ON v.usuario_id = u.id_usuario
        WHERE u.email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $login);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
function formatarTelefone($telefone)
{
    $telefone = preg_replace('/\D/', '', $telefone);
    if (strlen($telefone) == 11) {
        return preg_replace('/^(\d{2})(\d{5})(\d{4})$/', '($1) $2-$3', $telefone);
    } elseif (strlen($telefone) == 10) {
        return preg_replace('/^(\d{2})(\d{4})(\d{4})$/', '($1) $2-$3', $telefone);
    } else {
        return $telefone;
    }
}

$_SESSION['telefone'] = formatarTelefone($_SESSION['telefone']);

$Valor_total = 0;
foreach ($usuarios as $compra) {
    $Valor_total += $compra['valor'];
}
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
            gap: 2dvh;
            padding-bottom: 2dvh;
            width: 100%;
            height: auto;
        }

        main a {
            width: 35dvh;
            padding: 2dvh;
            font-size: 3dvh;
            background: none;
            border: .5dvh solid #000000;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        main h1 {
            background: none;
            font-size: 5.5dvh;
            text-align: center;
            margin: 1.2dvh 0 0dvh 0;
            padding: 2.5dvh 0 0 0;
        }

        main h1 {
            background: none;
        }

        #sair:hover {
            background: #c30000;
            color: #ffffff;
            border: .5dvh solid #c30000;
        }

        #dados:hover {
            background: #1870d5;
            color: #ffffff;
            border: .5dvh solid #1870d5;
        }

        .btns {
            margin-top: 3dvh;
            margin-bottom: 2dvh;
        }

        #customers td,
        #customers th {
            border: 1px solid #f2f2f2;
            padding: 10px;
            font-size: 2.5dvh;
        }

        #customers th {
            background-color: #f2f2f2;
            color: #000000;
        }

        form .alterar {
            margin-top: 1dvh;
            all: inherit;
            background: #1870d5;
            color: #ffffff;
            padding: .5dvh;
            border-radius: 5px;
            font-size: 2.6dvh;
            cursor: pointer;
        }

        .dados {
            border: .3dvh solid #f2f2f2;
            transition: all .3s ease;
        }

        .dados:hover {
            border: .3dvh solid #1870d5;
            background: #1870d5;
        }

        h3{
            font-size: 3dvh;
        }
    </style>
</head>

<body>


    <div class="subnav">
        <a href="sessao.php">Conta</a>
        <a href="user.php">Inicio</a>
        <div class="log">
            <h1><b><a href="../index.html">PrimerPhone</a></b></h1>
        </div>
        <a href="../php/cadastrouser.html">Cadastro</a>
        <a href="../php/loginuser.html">Login</a>
    </div>

    <main>
        <h1>Bem vindo Usuario(a)<br><?php echo $_SESSION['nome']; ?> </h1>
        <div class="Inform">
            <h2>Seus dados</h2>
            <ul>
                <li>Nome: <?php echo $_SESSION['nome']; ?></li>
                <li>E-mail: <?php echo $_SESSION['email']; ?></li>
                <li>Telefone: <?php echo $_SESSION['telefone']; ?></li>
                <li>Senha: <?php echo $_SESSION['senha']; ?></li>
                <li>Tipo de usuario: <?php echo $_SESSION['usuario_tipo']; ?></li>
                <form method="post" action="../dados/delete_alter/usuario/alterUser.php">
                    <input type="hidden" name="id" value="<?= $_SESSION['id_user']; ?>">
                    <input type="hidden" name="page" value="sessao">
                    <input type="hidden" name="area" value="usuarios">
                    <button type="submit" class="alterar"
                        onclick="return confirm('Tem certeza que deseja alterar?');">Altualizar dados</button>
                </form>
            </ul>
        </div>
        <div class="Inform">
            <h2>Funções</h2>
            <a href="admin.php" class="dados">Administrador</a>
            <a href="../php/loginFn.php" class="dados">Fornecedor</a>
        </div>
        <div class="compras">
            <h2>Compras</h2>
            <div class="tabela">
                <table id="customers">
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Comprador</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Cancelar</th>
                    </tr>
                    <?php foreach ($usuarios as $compras) {

                        $data_compra_formatada = (new DateTime($compras["data_venda"]))->format('d/m/Y');
                        ?>
                        <tr>
                            <td><?= $compras['celular_nome']; ?></td>
                            <td><?= $compras['quantidade']; ?></td>
                            <td><?= $compras['usuario_nome']; ?></td>
                            <td><?= $data_compra_formatada; ?></td>
                            <td><?= "R$ " . number_format($compras['valor'], 2, ',', '.'); ?></td>
                            <td>
                                <form method="post" action="../dados/delete_alter/deleteVd.php">
                                    <input type="hidden" name="id" value="<?= $compra['id_venda']; ?>">
                                    <input type="hidden" name="page" value="sessao">
                                    <input type="hidden" name="area" value="vendas">
                                    <button type="submit" class="deletar"
                                        onclick="return confirm('Tem certeza que deseja deletar?');">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <h3>Valor total: R$ <?php echo number_format($Valor_total, 2, ',', '.'); ?></h3 style="font-sizer: 60px;">
        </div>
        </div>
        <div class="btns">
            <a href="../cruds/exit.php" id="sair">Sair</a>
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