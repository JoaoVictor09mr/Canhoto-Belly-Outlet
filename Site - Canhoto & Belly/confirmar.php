<?php
if(!isset($_SESSION))
    session_start();

if(empty($_SESSION['usuario']))
{
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['produto']) && isset($_POST['valor']))
    {
        $_SESSION['produto'] = $_POST['produto'];
        $_SESSION['valor'] = $_POST['valor'];
    }
}

$produto = isset($_SESSION['produto']) ? $_SESSION['produto'] : '';
$valor = isset($_SESSION['valor']) ? $_SESSION['valor'] : '';

if($produto == '' || $valor == '')
{
    header("Location: produtos.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação da Compra</title>
    <link rel="stylesheet" href="css/style5.css">
</head>
<body>
    <div class="conteiner">
        <div class="caixa-formulario">
            <h1>Confirmação da Compra</h1>
            <div class="info">
                <strong>Produto:</strong>
                <br>
                <?php echo htmlspecialchars($produto, ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <div class="info">
                <strong>Valor:</strong>
                <br>
                R$ <?php echo htmlspecialchars($valor, ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <div class="info">
                <strong>Usuário:</strong>
                <br>
                <?php echo htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <form action="salvar_venda.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="origem" value="compra_direta">
                <select name="pagamento" required>
                    <option value="">Forma de pagamento</option>
                    <option value="Pix">Pix</option>
                    <option value="Cartão">Cartão</option>
                    <option value="Boleto">Boleto</option>
                </select>

                <p><strong>Comprovante de pagamento</strong></p>
                <input type="file" name="comprovante" accept=".jpg,.jpeg,.png,.pdf" required>
                <small>Formatos permitidos: JPG, PNG ou PDF. Tamanho máximo: 2 MiB.</small>

                <button type="submit" class="botao botao-center">
                    Finalizar Compra
                </button>
            </form>
        </div>
    </div>
</body>
</html>
