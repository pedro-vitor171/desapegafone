<?php
require_once '../cruds/conexao.php';
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
        main{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
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
            <h1>Usuarios</h1>
            <table id="customers">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Deletar</th>
                    <th>Alterar</th>
                </tr>
                <?php foreach ($usuarios as $usuario) { ?>
                    <tr>
                        <td><?php echo $usuario['id_usuario']; ?></td>
                        <td><?php echo $usuario['nome']; ?></td>
                        <td><?php echo $usuario['telefone']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td>
                            <form method="post" action="delete_alter/delete.php">
                                <input type="hidden" name="id" value="<?= $usuario['id_usuario']; ?>">
                                <input type="hidden" name="page" value="usuarios">
                                <input type="hidden" name="area" value="usuarios">
                                <button type="submit" class="deletar"
                                    onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="delete_alter/usuario/alterUser.php">
                                <input type="hidden" name="id" value="<?= $usuario['id_usuario']; ?>">
                                <input type="hidden" name="page" value="usuarios">
                                <input type="hidden" name="area" value="usuarios">
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