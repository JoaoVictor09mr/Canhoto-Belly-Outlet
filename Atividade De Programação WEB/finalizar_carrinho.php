<?php
if(!isset($_SESSION))
    session_start();

if(empty($_SESSION['usuario']))
{
    header("Location: login.php");
    exit;
}
if(!isset($_SESSION['carrinho']))
{
    header("Location: produtos.php");
    exit;
}

$total = 0;

foreach($_SESSION['carrinho'] as $item)
{
    $total += $item['valor'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resumo da Compra</title>

    <link rel="stylesheet" href="css/style7.css">
</head>
<body>
<div class="caixa-carrinho">
    <h1>Resumo da Compra</h1>
    <?php

    foreach($_SESSION['carrinho'] as $item)
    {
        echo "<div class='produto'>";
        echo $item['produto'];
        echo "<br>";
        echo "R$ ".$item['valor'];
        echo "</div>";
    }
    ?>
    <div class="total">
        Total: R$ <?php echo number_format($total,2,",","."); ?>
    </div>
    <form action="salvar_venda.php" method="POST">
        <button type="submit" class="botao" name="b1">
            Confirmar Compra
        </button>
    </form>
</div>

</body>
</html>