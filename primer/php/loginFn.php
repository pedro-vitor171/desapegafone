<?php
session_start();
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);
}
if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Fornecedor') {
    $_SESSION['message'] = 'Fornecedor cadastrado com sucesso.';
    header("Location: ../dados/fornecedores.php");
    exit();
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
        main{
            padding: 5dvh 0;
        }
        form {
            display: grid;
            place-items: center;
            width: 1000px;
            padding: 30px 0px;
            width: 700px;
        }

        form a {
            color: #F9F6F5;
            transition: all .3s ease;
        }

        form a:hover {
            color: #1870d5;
        }
    </style>
    <title>Login</title>
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
            <form action="../cruds/Fornlogin.php" method="POST">
                <h1>Login Fornecedor</h1>
                <label for="email"></label>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="cnpj"></label>
                <input type="password" name="cnpj" id="cnpj" placeholder="Cnpj" required>
                <label for="submit"></label>
                <input class="btn" type="submit" value="Entrar" id="sub" name="submit" />
                <a href="cadastroFn.php">Login</a>
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