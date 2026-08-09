<?php
include "app/cons.php";
require_once "app/DLL.php";

if (!isset($_SESSION))
    session_start();

if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$pagamento = limpar($_POST['pagamento'] ?? 'Não informado');
$numeroVenda = date("YmdHis") . rand(10, 99);
$usuario = limpar($_SESSION['usuario']);
$dataHoraBanco = date("Y-m-d H:i:s");
$dataHoraExibicao = date("d/m/Y H:i:s");
$total = 0;
$produtosComprados = [];

// Compra feita pelo carrinho.
if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
    foreach ($_SESSION['carrinho'] as $item) {
        $produto = limpar($item['produto']);
        $valor = (float)str_replace(',', '.', $item['valor']);

        $consulta = "INSERT INTO vendas
            (numero_venda, usuario, produto, valor, pagamento, data_hora)
            VALUES
            ('$numeroVenda', '$usuario', '$produto', $valor, '$pagamento', '$dataHoraBanco')";

        banco($server, $user, $password, $db, $consulta);

        $total += $valor;
        $produtosComprados[] = $item['produto'];
    }
} else {
    // Compra direta de um único produto.
    $produto = limpar($_POST['produto'] ?? '');
    $valor = (float)str_replace(',', '.', $_POST['valor'] ?? 0);

    if ($produto == '' || $valor <= 0) {
        header('Location: produtos.php');
        exit;
    }

    $consulta = "INSERT INTO vendas
        (numero_venda, usuario, produto, valor, pagamento, data_hora)
        VALUES
        ('$numeroVenda', '$usuario', '$produto', $valor, '$pagamento', '$dataHoraBanco')";

    banco($server, $user, $password, $db, $consulta);

    $total = $valor;
    $produtosComprados[] = $produto;
}

unset($_SESSION['carrinho']);
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
            <strong>Número da venda:</strong><br>
            <?php echo htmlspecialchars($numeroVenda); ?>
        </div>

        <div class="info">
            <strong>Cliente:</strong><br>
            <?php echo htmlspecialchars($usuario); ?>
        </div>

        <div class="info">
            <strong>Produtos:</strong><br>
            <?php
            foreach ($produtosComprados as $produto) {
                echo htmlspecialchars($produto) . "<br>";
            }
            ?>
        </div>

        <div class="info">
            <strong>Valor Total:</strong><br>
            R$ <?php echo number_format($total, 2, ",", "."); ?>
        </div>

        <div class="info">
            <strong>Forma de pagamento:</strong><br>
            <?php echo htmlspecialchars($pagamento); ?>
        </div>

        <div class="info">
            <strong>Data e Hora:</strong><br>
            <?php echo $dataHoraExibicao; ?>
        </div>

        <p>Venda concluída com sucesso!</p>

        <a href="produtos.php" class="botao">Voltar para Loja</a>
    </div>
</body>
</html>
