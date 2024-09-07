<?php
require_once '../cruds/conexao.php';
session_start();
if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Usuario') {
    header("Location: ../sessao/sessao.php");
    exit();
}
function formatarTelefone($telefone) {
    $telefone = preg_replace('/\D/', '', $telefone);
    
    if (strlen($telefone) == 11) {
        return preg_replace('/^(\d{2})(\d{5})(\d{4})$/', '($1) $2-$3', $telefone);
    } elseif (strlen($telefone) == 10) {
        return preg_replace('/^(\d{2})(\d{4})(\d{4})$/', '($1) $2-$3', $telefone);
    }
    
    return $telefone; 
}

$sql = "SELECT * FROM usuarios ORDER BY id_usuario DESC";
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
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .Inform {
            width: 75%;
            text-align: center;
            margin: 5.5dvh 0;
        }

        table {
            width: 100%;
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
            <h1>Usuários</h1>
            <table id="customers">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>senha</th>
                    <th>Deletar</th>
                    <th>Alterar</th>
                </tr>
                <?php foreach ($usuarios as $usuario) { ?>
                    <tr>
                        <td><?php echo $usuario['id_usuario']; ?></td>
                        <td><?php echo $usuario['nome']; ?></td>
                        <td><?php echo formatarTelefone($usuario['telefone']); ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td><?php echo $usuario['senha']; ?></td>
                        <td>
                            <form method="post" action="delete_alter/delete.php">
                                <input type="hidden" name="id" value="<?= $usuario['id_usuario']; ?>">
                                <input type="hidden" name="page" value="usuarios">
                                <input type="hidden" name="area" value="usuarios">
                                <button type="submit" class="deletar" onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="delete_alter/usuario/alterUser.php">
                                <input type="hidden" name="id" value="<?= $usuario['id_usuario']; ?>">
                                <input type="hidden" name="page" value="usuarios">
                                <input type="hidden" name="area" value="usuarios">
                                <button type="submit" class="alterar" onclick="return confirm('Tem certeza que deseja alterar?');">Alterar</button>
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
