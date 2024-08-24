<?php
require_once '../../../cruds/conexao.php';

// Receber o ID da marca via POST
$id = $_POST['id'];

// Verificar se o ID foi enviado
if (isset($id)) {
    // Carregar os dados da marca para pré-preenchimento do formulário
    $sql_celular = "SELECT * FROM celulares WHERE id_celular = :id_celular";
    $stmt_celular = $pdo->prepare($sql_celular);
    $stmt_celular->bindParam(':id_celular', $id);
    $stmt_celular->execute();
    $celular = $stmt_celular->fetch(PDO::FETCH_ASSOC);

    if ($celular) {
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
        select{
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
            <form action="authProd.php" method="post">
                <h1>Cadastro produto</h1>
                <input type="hidden" name="id" value="<?= $celular['id_celular']; ?>">
                <label for="nome"></label>
                <input type="text" name="nome" id="nome" value="<?= $celular['nome']; ?>" placeholder="Nome" required>
                <label for="marca"></label>
                <select name="marca_id" id="marca">
                    <?php
                    $sql = "SELECT id_marca, nome FROM marca";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($marcas as $marca) {
                        $selected = '';
                        if (isset($celular['marca_id']) && $celular['marca_id'] == $marca['id_marca']) {
                            $selected = 'selected';
                        }
                        echo "<option value='{$marca['id_marca']}' $selected>{$marca['nome']}</option>";
                    }
                    ?>
                </select>
                <label for="geracao"></label>
                <input type="text" name="geracao" id="geracao" value="<?= $celular['geracao']; ?>" placeholder="geracao"  required>
                <label for="valor"></label>
                <input type="number" name="valor" id="valor" value="<?= $celular['valor']; ?>" placeholder="valor" required>
                <label for="submit"></label>
                <input class="btn" type="submit" value="cadastrar" id="sub" name="submit"/>
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