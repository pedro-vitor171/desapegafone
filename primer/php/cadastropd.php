<?php
session_start();
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);
}
require_once '../cruds/conexao.php';
$sql = "SELECT id_marca, nome FROM marca";
$stmt = $pdo->query($sql); 
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/login_cadastro.css">
    <link rel="shortcut icon" href="../css/imgs/arch.svg" type="image/x-icon">
    <style>
        main {
            padding-top: 15dvh;
            padding-bottom: 15dvh;
        }

        form {
            display: grid;
            place-items: center;
            width: 1000px;
            padding: 10px 0px;
            width: 800px;
        }

        select {
            all: inherit;
            width: 550px;
            height: 65px;
            border-radius: 10px;
            padding: 20px 20px 0px;
            font-size: 36px;
            background-color: #F9F6F5;
            color: #000000;
            margin-top: -1.5dvh;
            margin-bottom: -2dvh;
        }

        option {
            color: #000000;
            background-color: #fff;
            padding: 5px;
        }
    </style>
    <title>Cadastro</title>
</head>

<body>

    <div class="subnav">
        <a href="../sessao/sessao.php">Conta</a>
        <a href="../sessao/user.php">Inicio</a>
        <div class="log">
            <h1><b><a href="../index.html">PrimerPhone</a></b></h1>
        </div>
        <a href="cadastrouser.php">Cadastro</a>
        <a href="loginuser.php">Login</a>
    </div>

    <main>
        <div class="for">
            <form action="../cruds/cadastrocell.php" method="post">
                <h1>Cadastro produto</h1>
                <label for="id"></label>
                <input type="hidden" name="id" id="id" value="<?= $_SESSION['id']; ?>" placeholder="id" required>
                <label for="nome"></label>
                <input type="text" name="nome" id="nome" placeholder="Nome" required>
                <label for="marca"></label>
                <select name="marca" id="marca">
                    <?php while ($marca = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$marca['id_marca']}'>+ {$marca['nome']}</option>";
                    } ?>
                </select>
                <label for="geracao"></label>
                <input type="text" name="geracao" id="geracao" placeholder="geracao" required>
                <label for="valor"></label>
                <input type="number" name="valor" id="valor" placeholder="valor" required>
                <label for="estoque"></label>
                <input type="number" name="estoque" id="estoque" placeholder="Estoque" required>
                <label for="submit"></label>
                <input class="btn" type="submit" value="cadastrar" id="sub" name="submit" />
            </form>
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