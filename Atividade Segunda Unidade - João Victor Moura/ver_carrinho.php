<?php
if (!isset($_SESSION))
    session_start();

if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$total = 0;

if (isset($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $total += (float)str_replace(',', '.', $item['valor']);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="css/style7.css">
</head>
<body>
<div class="caixa-carrinho">
    <h1>Resumo da Compra</h1>
    <?php
    if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
        foreach ($_SESSION['carrinho'] as $item) {
            echo "<div class='produto'>";
            echo htmlspecialchars($item['produto']);
            echo "<br>";
            echo "R$ " . number_format((float)str_replace(',', '.', $item['valor']), 2, ',', '.');
            echo "</div>";
        }
    ?>
        <div class="total">
            Total: R$ <?php echo number_format($total, 2, ",", "."); ?>
        </div>
        <form action="salvar_venda.php" method="POST">
            <select name="pagamento" required>
                <option value="">Forma de pagamento</option>
                <option value="Pix">Pix</option>
                <option value="Cartão">Cartão</option>
                <option value="Boleto">Boleto</option>
            </select>
            <button type="submit" class="botao" name="b1">
                Confirmar Compra
            </button>
        </form>
    <?php
    } else {
        echo "<p>Seu carrinho está vazio.</p>";
    }
    ?>
</div>
</body>
</html>
