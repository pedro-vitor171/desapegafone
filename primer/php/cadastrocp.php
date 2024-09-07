<?php
require_once '../cruds/conexao.php';
session_start();
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);
}

if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Adm') {
    header("Location: loginuser.php");
    $_SESSION['message'] = 'Você está logado como Adm e não possui permissão para acessar esta página.';
    exit();
}
if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Fornecedor') {
    header("Location: loginuser.php");
    $_SESSION['message'] = 'Você está logado como Fornecedor e não possui permissão para acessar esta página.';
    exit();
}

$sql = "SELECT id_celular, nome, valor, estoque FROM celulares";
$stmt = $pdo->query($sql);

$celulares = [];
while ($celular = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $celulares[$celular['id_celular']] = $celular;
}

$sql = "SELECT id_usuario, nome FROM usuarios";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        main {
            padding: 20dvh 0;
        }
        form {
            display: grid;
            place-items: center;
            width: 1000px;
            padding: 2dvh 0px;
            width: 800px;
        }
        input[type="number"] {
            width: 550px;
            height: 65px;
            border-radius: 10px;
            padding: 20px;
            font-size: 36px;
            background-color: #F9F6F5;
            color: #000000;
            margin-top: 1dvh;
            margin-bottom: -1dvh;
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
        <a href="cadastrouser.php">Cadastro</a>
        <a href="loginuser.php">Login</a>
    </div>
    <main>
        <div class="for">
            <form action="../cruds/cadastrocompra.php" method="post" onsubmit="return validarQuantidade()">
                <h1>Realizar compra</h1>
                <input type="hidden" name="id" value="<?= htmlspecialchars($_SESSION['id_user']); ?>">
                <br>
                <h2><b>Produto:</b> <?= htmlspecialchars($celulares[$_POST['celular_id']]['nome']); ?></h2>
                <h2><b>Valor unitário:</b> R$
                    <?= number_format($celulares[$_POST['celular_id']]['valor'], 2, ',', '.'); ?></h2>
                <h2><b>Data da compra:</b> <?= date('Y-m-d'); ?></h2>
                <h2><b>Comprador:</b> <?= htmlspecialchars($_SESSION['nome']); ?></h2>
                <br>
                <label for="quantidade"><b><h2>Quantidade:</h2></b></label>
                <input type="number" name="quantidade" id="quantidade" min="1" max="<?= htmlspecialchars($celulares[$_POST['celular_id']]['estoque']); ?>" onchange="atualizarValor()" required>
                <br>
                <h2><b>Valor total:</b><h2 id="valor_total"><?= "R$ ".number_format($_POST['valor'] * 1.5, 2, ',', '.'); ?></h2></h2>
                <br>
                <input type="hidden" name="celular_id" value="<?= htmlspecialchars($_POST['celular_id']); ?>">
                <input type="hidden" name="comprador" value="<?= htmlspecialchars($_SESSION['id_user']); ?>">
                <input type="hidden" name="data" value="<?= date('Y-m-d'); ?>">
                <input type="hidden" name="valor_unitario" value="<?= htmlspecialchars($celulares[$_POST['celular_id']]['valor']); ?>">
                <input type="hidden" name="valor_total" id="valor_total_input" value="<?= htmlspecialchars($_POST['valor'] * 1.5); ?>">
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
            const valorTotal = (quantidade * valorUnitario * 1.5).toFixed(2); // Multiplicando por 1.5
            document.getElementById('valor_total').textContent = "R$ " + valorTotal.replace('.', ',');
            document.getElementById('valor_total_input').value = valorTotal;
        }

        function validarQuantidade() {
            const quantidade = parseInt(document.getElementById('quantidade').value, 10);
            const estoque = parseInt(document.querySelector('input[name="quantidade"]').max, 10);

            if (quantidade > estoque) {
                alert('Quantidade solicitada excede o estoque disponível.');
                return false; 
            }
            return true; 
        }
    </script>
</body>
</html>
