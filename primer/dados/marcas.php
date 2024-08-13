<?php
require_once '../cruds/conexao.php';
$sql = "SELECT * FROM marca ORDER BY nome DESC";
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
</head>

<body>


    <div class="subnav">
        <a href="">Suporte</a>
        <a href="">Sobre</a>
        <div class="log">
            <h1><b><a href="index.html">PrimerPhone</a></b></h1>
        </div>
        <a href="php/cadastrouser.html">Cadastro</a>
        <a href="php/loginuser.html">Login</a>
    </div>

    <main>
        <table id="customers">
            <tr>
                <th>Nome</th>
            </tr>
            <?php foreach ($usuarios as $row) { ?>
                <tr>
                    <td><?php echo $row['nome']; ?></td>
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
            <p>Numero de telefone:</p>
            <p>E-mail:</p>
        </div>
        <div class="names">
            <h2>Redes Sociais:</h2>
            <p>Github:</p>
            <p>Instagram:</p>
            <p>Twitter:</p>
        </div>
        </div>
    </footer>
</body>

</html>