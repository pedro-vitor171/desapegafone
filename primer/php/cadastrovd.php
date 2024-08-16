<?php
    require_once '../cruds/conexao.php';
    $sql = "SELECT id_celular, nome FROM celulares";
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
                padding: 1px 20px;
                font-size: 25px;
                background-color: none;
                color: #F9F6F5;
                margin-top: -.8dvh;
                margin-bottom: -6.5dvh;
            }
    </style>
    <title>Cadastro venda</title>
</head>
<body>

    <div class="subnav">
                <a href="../sessao/sessao.php">Conta</a>
                <a href="">Sobre</a>
                <div class="log">
                    <h1><b><a href="../index.html">PrimerPhone</a></b></h1>
                </div>
                <a href="cadastrouser.html">Cadastro</a>
                <a href="loginuser.html">Login</a>            
        </div>

        <main>       
            <div class="for">     
            <form action="../cruds/cadastrovenda.php" method="post">
                <h1>Cadastro venda</h1>
                <label for="produto"></label>
                <select name="produto" id="produto">
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['id_celular']}'>+ {$row['nome']}</option>";
                }?>
                </select>                
                <label for="comprador"></label>
                <input type="text" name="comprador" id="comprador" placeholder="Comprador" required>
                <label for="data"></label>
                <input type="date" name="data" id="data" placeholder="Data"  required>
                <label for="valor"></label>
                <input type="number" name="valor" id="valor" placeholder="Valor" required>
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