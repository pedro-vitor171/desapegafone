<?php
require_once '../cruds/conexao.php';

$sql = "SELECT c.id_celular, c.nome AS nome_celular, m.nome AS nome_marca, c.valor, c.estoque
        FROM celulares c
        INNER JOIN marca m ON c.marca_id = m.id_marca";

$stmt = $pdo->query($sql);
$celulares = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<html>
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
            align-items: start;
            justify-content: start;
            padding-bottom: 2dvh;
            width: 100%;
            height: 100vh;
        }
        .con{
            margin-top: 3dvh;
            margin-left: 3dvh;
            display: flex;
            flex-direction: column;
            margin-bottom: 3dvh;
        }
        ul, li, button{
            all: inherit;
        }
        img{
            height: 46dvh;
            width: 36dvh;
            border-radius: 10px;
            background-size: cover;
        }
        li{
            background-color: #000000;
            padding: 1dvh;
            border-radius: 10px;
            gap: 2dvh;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;        
        }
        .line{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 9dvh;
        }
        .prod{
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: .5s ease;
        }
        .prod:hover{
            transform: scale(1.05);
        }
        button[type="submit"]{
            background-color: #000000;
            color: #ffffff;
            padding: 1dvh;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: .5s ease;
            font-size: 3.5dvh;
        }
        button[type="submit"]:hover{
            background: #1870d5;
            transform: scale(1.05);
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
        <di class="con">
    <h1>Produtos</h1>
    <div class="line">
    <?php
      foreach ($celulares as $celular) {
          $imagem = "../css/imgs/marcas/{$celular['nome_marca']}.jpg";

          if (file_exists($imagem)) {
              $imagemSrc = $imagem;
          } else {
              $imagemSrc = "https://t.ctcdn.com.br/BX4PjxFUUDLPTZnFitPWS1oSjOU=/i723190.jpeg"; 
          }
          ?>
          <div class="prod">
            <li>
              <img src="<?= $imagemSrc ?>" alt="<?= $celular['nome_celular'] ?>">
              <h2><?= $celular['nome_celular'] ?></h2>
              <p><?= $celular['nome_marca'] ?></p>
              <p>Produtos disponiveis: <?= $celular['estoque'] ?></p>
              <p>Preço: R$ <?= number_format($celular['valor'], 2, ',', '.') ?></p>
              <form action="../php/cadastrovd.php" method="POST">
                <input type="hidden" name="celular_id" value="<?= $celular['id_celular'] ?>">
                <button type="submit">Comprar</button>
            </form>
            </li>
          </div>
      <?php
      }
      ?>
    </div>
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