<?php
require_once '../../../cruds/conexao.php';

// Receber o ID da marca via POST
$id = $_POST['id'];

// Verificar se o ID foi enviado
if (isset($id)) {
    // Carregar os dados da marca para pré-preenchimento do formulário
    $sql_usuario = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt_usuario = $pdo->prepare($sql_usuario);
    $stmt_usuario->bindParam(':id_usuario', $id);
    $stmt_usuario->execute();
    $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Exibir formulário de alteração com os dados pré-preenchidos
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
      main{
            padding-top: 10dvh;
            padding-bottom: 10dvh;
        }
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
            <form action="authUser.php" method="post">
                <h1>Modificar usuario</h1>
                <input type="hidden" name="id" value="<?= $usuario['id_usuario']; ?>">
                <label for="nome"></label>
                <input type="text" name="nome" id="nome" value="<?= $usuario['nome']; ?>" placeholder="Nome" required>
                <label for="telefone"></label>
                <input type="text" name="telefone" id="telefone" value="<?= $usuario['telefone']; ?>" placeholder="Telefone" required>
                <label for="email"></label>
                <input type="email" name="email" id="email" value="<?= $usuario['email']; ?>" placeholder="Email"  required>
                <label for="senha"></label>
                <input type="password" name="senha" id="senha" value="<?= $usuario['senha']; ?>" placeholder="Senha" required>
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