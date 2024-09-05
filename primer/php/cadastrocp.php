<!DOCTYPE html>
<html lang="pt-br">
<?php
require_once '../cruds/conexao.php';
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ../php/loginuser.html');
    echo "<script>alert('Por favor, realize o login. ')</script>";
    exit;
}
$sql = "SELECT id_celular, nome, valor FROM celulares";
$stmt = $pdo->query($sql);

$celulares = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $celulares[$row['id_celular']] = $row;
}
$usuarios = [];
$sql = "SELECT id_usuario, nome FROM usuarios";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/login_cadastro.css">
    <link rel="shortcut icon" href="../css/imgs/arch.svg" type="image/x-icon">
    <style>
        main {
            padding-top: 10dvh;
            padding-bottom: 10dvh;
        }

        form {
            display: grid;
            place-items: center;
            width: 1000px;
            padding: 10px 0px;
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
            margin-top: 1dvh;
            margin-bottom: -1dvh;
        }

        option {
            color: #000000;
            background-color: #fff;
            padding: 5px;
        }

        h1 {
            margin-bottom: 2.5dvh;
        }
    </style>
    <title>Cadastro venda</title>
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
            <form action="../cruds/cadastrocompra.php" method="post">
                <h1>Realizar compra</h1>
                <input type="hidden" name="id" value="<?= $_SESSION['id_user']; ?>">
                <br>
                <h2><b>Produto:</b> <?= $celulares[$_POST['celular_id']]['nome']; ?></h2>
                <h2><b>Valor unitário:</b> R$
                    <?= number_format($celulares[$_POST['celular_id']]['valor'], 2, ',', '.'); ?></h2>
                <h2><b>Data da compra:</b> <?= date('Y-m-d'); ?></h2>
                <h2><b>Comprador:</b> <?= $_SESSION['nome']; ?></h2>
                <br>
                <label for="quantidade"><b>Quantidade:</b></label>
                <select name="quantidade" id="quantidade" onchange="atualizarValor()">
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <br>
                <h2><b>Valor total:</b> R$ <h2 id="valor_total"><?= number_format($_POST['valor'] * 1, 2, ',', '.'); ?></h2></h4>
                <br>
                <input type="hidden" name="celular_id" value="<?= $_POST['celular_id']; ?>">
                <input type="hidden" name="comprador" value="<?= $_SESSION['id_user']; ?>">
                <input type="hidden" name="data" value="<?= date('Y-m-d'); ?>">
                <input type="hidden" name="valor_unitario" value="<?= $celulares[$_POST['celular_id']]['valor']; ?>">
                <input type="hidden" name="valor_total" id="valor_total_input" value="<?= $_POST['valor']; ?>">

                <input class="btn" type="submit" value="Confirmar compra" id="sub" name="submit" />
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

    <script>
        function atualizarValor() {
            const quantidade = document.getElementById('quantidade').value;
            const valorUnitario = parseFloat(document.querySelector('input[name="valor_unitario"]').value);
            const valorTotal = (quantidade * valorUnitario).toFixed(2);
            document.getElementById('valor_total').textContent = valorTotal.replace('.', ',');
            document.getElementById('valor_total_input').value = valorTotal;
        }
    </script>
</body>

</html>