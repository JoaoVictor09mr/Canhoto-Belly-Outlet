<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
    header('Location: produtos.php');
    exit;
}

$total = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $total += (float) str_replace(',', '.', $item['valor']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="css/style7.css">
</head>
<body>
<div class="caixa-carrinho">
    <h1>Resumo da Compra</h1>
    <?php foreach ($_SESSION['carrinho'] as $item) { ?>
        <div class="produto">
            <?php echo htmlspecialchars($item['produto'], ENT_QUOTES, 'UTF-8'); ?><br>
            R$ <?php echo htmlspecialchars($item['valor'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php } ?>
    <div class="total">Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></div>

    <form action="salvar_venda.php" method="POST" enctype="multipart/form-data">
        <label for="pagamento">Forma de pagamento</label>
        <select name="pagamento" id="pagamento" required>
            <option value="">Selecione</option>
            <option value="Pix">Pix</option>
            <option value="Cartão">Cartão</option>
            <option value="Boleto">Boleto</option>
        </select>
        <p><strong>Comprovante de pagamento</strong></p>
        <input type="file" name="comprovante" accept=".jpg,.jpeg,.png,.pdf" required>
        <small>Formatos permitidos: JPG, PNG ou PDF. Tamanho máximo: 2 MiB.</small>
        <button type="submit" class="botao" name="b1">Confirmar Compra</button>
    </form>
</div>
</body>
</html>
