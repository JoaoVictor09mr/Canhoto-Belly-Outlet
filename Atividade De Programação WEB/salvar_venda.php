<?php
include "app/cons.php";
require_once "app/DLL.php";

extract($_POST);

if(!isset($_SESSION))
    session_start();

if(empty($_SESSION['usuario']))
{
    header('Location: login.php');
    exit;
}

$numeroVenda = date("YmdHis");
$usuario = $_SESSION['usuario'];
$dataHora = date("Y-m-d H:i:s");

$total = 0;

if(isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0)
{
    foreach($_SESSION['carrinho'] as $item)
    {
        $produto = $item['produto'];
        $valor = str_replace(",", ".", $item['valor']);

        $total += (float)$valor;

        $consulta = "INSERT INTO vendas (Id, NumeroVenda, Usuario, DataHora, Produto, Valor) VALUES (NULL, '$numeroVenda', '$usuario', '$dataHora', '$produto', '$valor')";

        banco($server, $user, $password, $db, $consulta);
    }
}
else
{
    $valor = str_replace(",", ".", $valor);

    $consulta = "INSERT INTO vendas (Id, NumeroVenda, Usuario, DataHora, Produto, Valor)  VALUES (NULL, '$numeroVenda', '$usuario', '$dataHora', '$produto', '$valor')";

    banco($server, $user, $password, $db, $consulta);

    $total = (float)$valor;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Venda Registrada</title>
    <link rel="stylesheet" href="css/style5.css">
</head>
<body class="center">
    <div class="caixa-formulario">
        <h1>Venda registrada com sucesso!</h1>

        <div class="info">
            <strong>Número da venda:</strong>
            <br>
            <?php echo $numeroVenda; ?>
        </div>

        <div class="info">
            <strong>Cliente:</strong>
            <br>
            <?php echo $usuario; ?>
        </div>

        <div class="info">
            <strong>Produtos:</strong>
            <br>
            <?php
            if(isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0)
            {
                foreach($_SESSION['carrinho'] as $item)
                {
                    echo $item['produto']."<br>";
                }
            }
            else
            {
                echo $produto;
            }
            ?>
        </div>

        <div class="info">
            <strong>Valor Total:</strong>
            <br>
            R$ <?php echo number_format($total, 2, ",", "."); ?>
        </div>

        <div class="info">
            <strong>Data e Hora:</strong>
            <br>
            <?php echo date("d/m/Y H:i:s", strtotime($dataHora)); ?>
        </div>

        <p>Venda concluída com sucesso!</p>

        <a href="produtos.php" class="botao">
            Voltar para Loja
        </a>
    </div>
</body>
</html>

<?php
unset($_SESSION['carrinho']);
?>
