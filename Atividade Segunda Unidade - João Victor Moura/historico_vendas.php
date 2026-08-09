<?php
include "app/cons.php";
require_once "app/DLL.php";

if (!isset($_SESSION))
    session_start();

if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = limpar($_SESSION['usuario']);
$consulta = "SELECT numero_venda, produto, valor, pagamento, data_hora
             FROM vendas
             WHERE usuario = '$usuario'
             ORDER BY id DESC";
$resultado = banco($server, $user, $password, $db, $consulta);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Compras</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #f2f2f2; }
        a { display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Histórico de Compras</h1>
    <table>
        <tr>
            <th>Venda</th>
            <th>Produto</th>
            <th>Valor</th>
            <th>Pagamento</th>
            <th>Data</th>
        </tr>
        <?php while ($linha = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($linha['numero_venda']); ?></td>
            <td><?php echo htmlspecialchars($linha['produto']); ?></td>
            <td>R$ <?php echo number_format($linha['valor'], 2, ',', '.'); ?></td>
            <td><?php echo htmlspecialchars($linha['pagamento']); ?></td>
            <td><?php echo date('d/m/Y H:i:s', strtotime($linha['data_hora'])); ?></td>
        </tr>
        <?php } ?>
    </table>
    <a href="produtos.php">Voltar para a loja</a>
</body>
</html>
