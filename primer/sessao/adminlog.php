<?php
session_start();
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo"<script>window.location.href = 'admin.php';</script>";
    echo  "<script>alert('Por favor, realize o login.')</script>";
}
$login = $_SESSION['email'];
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
            padding-top: 10dvh;
            padding-bottom: 10dvh;
        }
        form{
            display: grid;
            place-items: center;
            width: 1000px;
            padding: 30px 0px;
            width: 700px;
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
                <a href="cadastrouser.html">Cadastro</a>
                <a href="loginuser.html">Login</a>            
        </div>

        <main>       
            <div class="for">     
            <form action="../cruds/admin.php" method="POST">
                <h1>Login Administrador</h1>
                <label for="cnpj"></label>
                <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ" required>
                <label for="email"></label>
                <input type="text" name="email" id="email" placeholder="Email"  required>
                <label for="senha"></label>
                <input type="password" name="senha" id="senha" placeholder="Senha" required>
                <label for="submit"></label>
                <input class="btn" type="submit" value="Entrar" id="sub" name="submit"/>
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
                <p><a href="adminlog.php">Adminlog</a></p>
                <p><a href="admin.php">Admins</a></p>
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