<?php
require_once '../cruds/conexao.php';
session_start();
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);
}
$sql = "
    SELECT f.id_fornecedor, f.nome, f.cnpj, f.telefone, f.email, f.endereco, 
           COALESCE(m.nome, 'Freelancer') AS marca_nome
    FROM fornecedor f
    LEFT JOIN marca m ON f.marca_id = m.id_marca
    ORDER BY f.id_fornecedor ASC
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

function formatarCNPJ($cnpj) {
    $cnpj = preg_replace('/\D/', '', $cnpj);
    
    if (strlen($cnpj) == 14) {
        return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $cnpj);
    }
    
    return $cnpj; 
}
function formatarTelefone($telefone)
{
    $telefone = preg_replace('/\D/', '', $telefone);
    
    if (strlen($telefone) == 11) {
        return preg_replace('/^(\d{2})(\d{5})(\d{4})$/', '($1) $2-$3', $telefone);
    } elseif (strlen($telefone) == 10) {
        return preg_replace('/^(\d{2})(\d{4})(\d{4})$/', '($1) $2-$3', $telefone);
    } else {
        return $telefone;
    }
}

foreach ($fornecedores as &$fornecedor) {
    $fornecedor['telefone'] = formatarTelefone($fornecedor['telefone']);
    $fornecedor['cnpj'] = formatarCNPJ($fornecedor['cnpj']);
}
unset($fornecedor);
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
        }

        .Inform {
            width: 95%;
            margin: 5dvh 0;
            text-align: center;
            padding: 3.6dvh;
            font-size: .6dvh;
        }

        table {
            width: 110%;
            border-collapse: collapse;
            text-align: center;
        }

        .deletar, .alterar {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="subnav">
        <a href="../sessao/sessao.php">Conta</a>
        <a href="../sessao/user.php">Inicio</a>
        <div class="log">
            <h1><b><a href="../index.html">PrimerPhone</a></b></h1>
        </div>
        <a href="../php/cadastrouser.php">Cadastro</a>
        <a href="../php/loginuser.php">Login</a>
    </div>

    <main>
        <div class="Inform">
            <h1>Fornecedores</h1>
            <table id="customers">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Endereço</th>
                    <th>Marca</th>
                    <th>Deletar</th>
                </tr>
                <?php foreach ($fornecedores as $fornecedor) { ?>
                    <tr>
                        <td><?php echo $fornecedor['id_fornecedor']; ?></td>
                        <td><?php echo $fornecedor['nome']; ?></td>
                        <td><?php echo $fornecedor['cnpj']; ?></td>
                        <td><?php echo $fornecedor['telefone']; ?></td>
                        <td><?php echo $fornecedor['email']; ?></td>
                        <td><?php echo $fornecedor['endereco']; ?></td>
                        <td><?php echo $fornecedor['marca_nome']; ?></td>
                        <td>
                            <form method="post" action="delete_alter/deleteForn.php">
                                <input type="hidden" name="id" value="<?php echo $fornecedor['id_fornecedor']; ?>">
                                <input type="hidden" name="area" value="fornecedores">
                                <button type="submit" class="deletar" onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
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
</body>

</html>
