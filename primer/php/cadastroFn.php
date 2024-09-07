<?php
require_once '../cruds/conexao.php';
$sql = "SELECT id_marca, nome FROM marca";
$stmt = $pdo->query($sql);
session_start();
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);
}
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
            padding-top: 25dvh;
            padding-bottom: 25dvh;
        }

        form {
            display: grid;
            place-items: center;
            width: 1000px;
            padding: 3dvh 0;
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
    <title>Cadastro Fornecedor</title>
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
            <form action="../cruds/cadastroforn.php" method="POST">
                <h1>Cadastro Fornecedor</h1>

                <label for="nome"></label>
                <input type="text" name="nome" id="nome" placeholder="Nome" required>

                <label for="cnpj"></label>
                <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ" required>

                <label for="telefone"></label>
                <input type="text" name="telefone" id="telefone" placeholder="Telefone">

                <label for="email"></label>
                <input type="email" name="email" id="email" placeholder="Email">

                <label for="endereco"></label>
                <input type="text" name="endereco" id="endereco" placeholder="Endereço">

                <label for="marca"></label>
                <select name="marca" id="marca">
                    <?php
                    while ($marcas = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$marcas['id_marca']}'>{$marcas['nome']}</option>";
                    }
                    ?>
                </select>

                <input class="btn" type="submit" value="Cadastrar" id="sub" name="submit">
                <a href="loginFn.php">Faça login</a>
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
    </footer>
</body>

</html>