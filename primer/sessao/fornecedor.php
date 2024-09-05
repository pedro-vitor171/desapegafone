<?php
session_start();
if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Usuario') {
    header("Location: sessao.php");
    echo "<script>alert('Por favor, realize o login.')</script>";
    exit();
}
if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Adm') {
    header("Location: fornecedor.php");
    echo "<script>alert('Por favor, realize o login.')</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
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
            height: 100vh;
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
            font-size: 5dvh;
            margin-top: 1dvh;
            margin-bottom: -6dvh;
        }

        main a {
            background: none;
        }

        a {
            cursor: pointer;
            transition: .5s ease;
        }

        a:hover {
            background: #000000;
            color: #ffffff;
            transform: scale(1.1);
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
            display: grid;
            gap: 4dvh;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(2, 1fr);
            margin-bottom: 7dvh;
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
        <h1>Seja Bem vindo <?php echo $_SESSION['nome'];?> </h1>
        <div class="btns">
            <a href="../dados/marcas.php" id="dados">Marcas</a>
            <a href="../dados/produtos.php" id="dados">Produtos</a>
            <a href="../dados/fornecedores.php" id="dados">Fornecedores</a>
            <a href="../php/cadastroFn.php" id="dados">Cadastrar fornecedores</a>
            <a href="../php/cadastromarca.html" id="dados">Cadastrar Marca</a>
            <a href="../php/cadastropd.php" id="dados">Cadastrar Produto</a>
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