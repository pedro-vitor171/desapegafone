<?php
require_once '../../../cruds/conexao.php';


$id = $_POST['id'];

if (isset($id)) {
    $sql_marca = "SELECT * FROM marca WHERE id_marca = :id_marca";
    $stmt_marca = $pdo->prepare($sql_marca);
    $stmt_marca->bindParam(':id_marca', $id);
    $stmt_marca->execute();
    $marca = $stmt_marca->fetch(PDO::FETCH_ASSOC);

    if ($marca) {
        ?>
        <!DOCTYPE html>
    <html lang="pt-br">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/index.css" />
    <link rel="stylesheet" href="../../../css/login_cadastro.css">
    <link rel="shortcut icon" href="../../../css/imgs/arch.svg" type="image/x-icon">
    <style>
        form{
            display: grid;
            place-items: center;
            width: 1000px;
            padding: 10px 0px;
            width: 800px;
        }
    </style>
    <title>Cadastro</title>
    </head>
    <body>
    <div class="subnav">
                <a href="../../../sessao/sessao.php">Conta</a>
                <a href="../../../sessao/user.php">Inicio</a>
                <div class="log">
                    <h1><b><a href="../../../index.html">PrimerPhone</a></b></h1>
                </div>
                <a href="../../../php/cadastrouser.html">Cadastro</a>
                <a href="../../../php/loginuser.html">Login</a>            
        </div>

        <main>
            <div class="for">
        <form method="post" action="authMarca.php">
            <h1>Modificar Marca</h1>
            <input type="hidden" name="id" value="<?= $marca['id_marca']; ?>">
            <label for="nome"></label>
            <input type="text" name="nome" value="<?= $marca['nome']; ?>">
            <label for="submit"></label>
            <input class="btn" type="submit" value="modificar" id="sub" name="submit"/>
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
                <p>E-mail: sentarebolando@gmail.com</p>
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
        <?php
    } else {
        // Exibir mensagem de erro se a marca não for encontrada
        echo "Marca não encontrada.";
    }
} else {
    // Exibir mensagem de erro se o ID não for enviado
    echo "ID da marca não enviado.";
}