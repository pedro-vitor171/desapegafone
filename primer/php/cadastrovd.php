<?php
require_once '../cruds/conexao.php';
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);
}
$sql = "SELECT id_celular, nome, valor FROM celulares";
$stmt = $pdo->query($sql);

$celulares = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $celulares[$row['id_celular']] = $row;
}
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
    </style>
    <title>Realizar venda</title>
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
            <form action="../cruds/cadastrovenda.php" method="post" onsubmit="return validarValor()">
                <h1>Realizar venda</h1>
                <label for="produto"></label>
                <select name="produto" id="produto" onchange="atualizarValor()">
                    <?php foreach ($celulares as $id_celular => $celular) { ?>
                        <option value="<?php echo $id_celular; ?>"><?php echo '+ ' . $celular['nome']; ?></option>
                    <?php } ?>
                </select>
                <select name="comprador" id="comprador">
                    <?php
                    $sql = "SELECT id_usuario, nome FROM usuarios";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($usuarios as $usuario) { ?>
                        <option value="<?php echo $usuario['id_usuario']; ?>"><?php echo $usuario['nome']; ?></option>
                    <?php } ?>
                </select>
                <label for="data"></label>
                <input type="date" name="data" id="data" placeholder="Data" required>
                <label for="valor"></label>
                <input type="number" name="valor" id="valor" placeholder="Valor" required>
                <label for="submit"></label>
                <input class="btn" type="submit" value="Entrar" id="sub" name="submit" />
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
            <p>Número de telefone: 77 95590-3454</p>
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
        var celulares = <?php echo json_encode($celulares); ?>;

        function atualizarValor() {
            var produtoSelecionado = document.getElementById("produto").value;
            var inputValor = document.getElementById("valor");
            var valorProduto = celulares[produtoSelecionado]?.valor || 0;
            var valorMultiplicado = valorProduto * 1.5;

            inputValor.value = valorMultiplicado;
            inputValor.min = valorProduto;
        }

        function validarValor() {
            var produtoSelecionado = document.getElementById("produto").value;
            var inputValor = document.getElementById("valor");
            var valorMinimo = celulares[produtoSelecionado]?.valor || 0;

            if (parseFloat(inputValor.value) < valorMinimo) {
                alert("O valor deve ser maior ou igual ao valor do produto.");
                return false; 
            }
            return true; 
        }

        window.onload = atualizarValor;
    </script>
</body>

</html>
