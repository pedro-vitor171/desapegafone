<?php
session_start();
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
  unset($_SESSION['email']);
  unset($_SESSION['senha']);
  echo "<script>window.location.href   
 ='../php/loginuser.html'</script>";
  echo "alert('Por favor, realize o login.')";
}
$login = $_SESSION['email'];
require_once '../cruds/conexao.php';

$sql = "SELECT v.*, c.nome AS celular_nome, u.nome AS usuario_nome
        FROM venda v
        INNER JOIN celulares c ON v.celular_id = c.id_celular
        INNER JOIN usuarios u ON v.usuario_id = u.id_usuario
        WHERE u.email = :email"; 
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $login);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/dados.css">
    <link rel="shortcut icon" href="../css/imgs/arch.svg" type="image/x-icon">
    <title>PrimerPhone</title>
    <style>
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0dvh;
            padding-bottom: 2dvh;
            width: 100%;
            height: 90vh;
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
            margin-top: -36dvh;
            margin-bottom: -15dvh;
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
        .btns{
            margin-top: 6.5dvh;
            margin-bottom: 1.5dvh;
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
        <h1>Seja Bem vindo <?php echo $login; ?></h1>
  <table id="customers">
    <tr>
      <th>Produto</th>
      <th>Comprador</th>
      <th>Data</th>
      <th>Valor</th>
    </tr>
    <?php foreach ($usuarios as $compras) { ?>
    <tr>
      <td><?= $compras['celular_nome']; ?></td>
      <td><?= $compras['usuario_nome']; ?></td>
      <td><?= $compras['data_venda']; ?></td>
      <td><?= $compras['valor']; ?></td>

    </tr>
    <?php } ?>
  </table>
  <div class="btns">
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