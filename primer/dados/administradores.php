<?php
require_once '../cruds/conexao.php';
session_start();
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);
}
function formatarCNPJ($cnpj) {
    $cnpj = preg_replace('/\D/', '', $cnpj);
    
    if (strlen($cnpj) == 14) {
        return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $cnpj);
    }
    
    return $cnpj; 
}

$sql = "
    SELECT * 
    FROM adm
    ORDER BY id ASC
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/dados.css">
    <link rel="shortcut icon" href="../css/imgs/arch.svg" type="image/x-icon">
    <title>Administração</title>
    <style>
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .Inform {
            width: 75%;
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
            <h1>Administradores</h1>
            <table id="customers">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Email</th>
                    <th>Senha</th>
                    <th>Deletar</th>
                </tr>
                <?php foreach ($admins as $admin) { ?>
                    <tr>
                        <td><?php echo $admin['id']; ?></td>
                        <td><?php echo $admin['nome']; ?></td>
                        <td><?php echo formatarCNPJ($admin['cnpj']); ?></td>
                        <td><?php echo $admin['email']; ?></td>
                        <td><?php echo $admin['senha']; ?></td>
                        <td>
                            <form method="post" action="delete_alter/deleteAdm.php">
                                <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
                                <input type="hidden" name="area" value="administradores">
                                <button type="submit" class="deletar" onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</button>
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
    </footer>
</body>
</html>
