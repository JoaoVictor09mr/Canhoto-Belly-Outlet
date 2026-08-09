<?php
if (!isset($_SESSION))
    session_start();

if (empty($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$produto = $_POST['produto'] ?? '';
$valor = $_POST['valor'] ?? '';

if ($produto == '' || $valor == '') {
    header('Location: produtos.php');
    exit;
}

$_SESSION['produto'] = $produto;
$_SESSION['valor'] = $valor;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmação da Compra</title>
    <link rel="stylesheet" href="css/style5.css">
</head>
<body>
    <div class="conteiner">
        <div class="caixa-formulario">
            <h1>Confirmação da Compra</h1>
            <div class="info">
                <strong>Produto:</strong><br>
                <?php echo htmlspecialchars($produto); ?>
            </div>
            <div class="info">
                <strong>Valor:</strong><br>
                R$ <?php echo number_format((float)str_replace(',', '.', $valor), 2, ',', '.'); ?>
            </div>
            <div class="info">
                <strong>Usuário:</strong><br>
                <?php echo htmlspecialchars($_SESSION['usuario']); ?>
            </div>
            <form action="salvar_venda.php" method="POST">
                <input type="hidden" name="produto" value="<?php echo htmlspecialchars($produto); ?>">
                <input type="hidden" name="valor" value="<?php echo htmlspecialchars($valor); ?>">
                <select name="pagamento" required>
                    <option value="">Forma de pagamento</option>
                    <option value="Pix">Pix</option>
                    <option value="Cartão">Cartão</option>
                    <option value="Boleto">Boleto</option>
                </select>
                <button type="submit" class="botao botao-center">
                    Finalizar Compra
                </button>
            </form>
        </div>
    </div>
</body>
</html>
