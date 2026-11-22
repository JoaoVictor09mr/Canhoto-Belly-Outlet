<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Finalize a compra pelo formulário. <a href="produtos.php">Voltar à loja</a>');
}

// Confere a forma de pagamento antes de armazenar o arquivo.
$pagamento = isset($_POST['pagamento']) ? trim($_POST['pagamento']) : '';
$formasPermitidas = array('Pix', 'Cartão', 'Boleto');
if (!in_array($pagamento, $formasPermitidas, true)) {
    exit('Forma de pagamento inválida. <a href="javascript:history.back()">Voltar</a>');
}

// Identifica se a compra veio do carrinho ou da compra direta.
$itensVenda = array();
if (!empty($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        if (!isset($item['produto'], $item['valor'])) {
            exit('Há um produto inválido no carrinho.');
        }
        $nome = trim($item['produto']);
        $valor = (float) str_replace(',', '.', $item['valor']);
        if ($nome === '' || $valor <= 0) {
            exit('Há um produto inválido no carrinho.');
        }
        $itensVenda[] = array('produto' => $nome, 'valor' => $valor);
    }
} else {
    $nome = isset($_SESSION['produto']) ? trim($_SESSION['produto']) : '';
    $valor = isset($_SESSION['valor']) ? (float) str_replace(',', '.', $_SESSION['valor']) : 0;
    if ($nome === '' || $valor <= 0) {
        exit('Não foi possível identificar o produto da compra. <a href="produtos.php">Voltar</a>');
    }
    $itensVenda[] = array('produto' => $nome, 'valor' => $valor);
}

// Recebe e valida o comprovante conforme o manual do professor.
if (!isset($_FILES['comprovante']) || !is_array($_FILES['comprovante'])) {
    exit('Comprovante não recebido. Confira o formulário de envio.');
}
$arquivo = $_FILES['comprovante'];

if ($arquivo['error'] !== UPLOAD_ERR_OK) {
    $mensagensErro = array(
        UPLOAD_ERR_INI_SIZE => 'O arquivo ultrapassa o limite definido no php.ini.',
        UPLOAD_ERR_FORM_SIZE => 'O arquivo ultrapassa o limite permitido pelo formulário.',
        UPLOAD_ERR_PARTIAL => 'O envio do arquivo foi incompleto. Tente novamente.',
        UPLOAD_ERR_NO_FILE => 'Nenhum comprovante foi selecionado.',
        UPLOAD_ERR_NO_TMP_DIR => 'A pasta temporária do PHP não foi encontrada.',
        UPLOAD_ERR_CANT_WRITE => 'O servidor não conseguiu gravar o arquivo temporário.',
        UPLOAD_ERR_EXTENSION => 'Uma extensão do PHP interrompeu o envio.'
    );
    $mensagem = isset($mensagensErro[$arquivo['error']]) ? $mensagensErro[$arquivo['error']] : 'Falha desconhecida no upload.';
    exit($mensagem . ' <a href="javascript:history.back()">Voltar</a>');
}

$limite = 2 * 1024 * 1024;
if ($arquivo['size'] <= 0 || $arquivo['size'] > $limite) {
    exit('O comprovante deve ter até 2 MiB. <a href="javascript:history.back()">Voltar</a>');
}

if (!is_uploaded_file($arquivo['tmp_name'])) {
    exit('O arquivo recebido não é um upload válido.');
}

$tiposPermitidos = array(
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'application/pdf' => 'pdf'
);
if (!function_exists('finfo_open')) {
    exit('A extensão fileinfo não está habilitada no PHP. Ative-a no php.ini e reinicie o Apache.');
}
$info = finfo_open(FILEINFO_MIME_TYPE);
if ($info === false) {
    exit('Não foi possível verificar o formato. Ative a extensão fileinfo no PHP.');
}
$tipoMime = finfo_file($info, $arquivo['tmp_name']);
finfo_close($info);

if ($tipoMime === false || !isset($tiposPermitidos[$tipoMime])) {
    exit('Formato inválido. Envie somente JPG, PNG ou PDF.');
}

$pastaUploads = __DIR__ . '/uploads/';
if (!is_dir($pastaUploads) && !mkdir($pastaUploads, 0755, true)) {
    exit('Não foi possível criar a pasta uploads.');
}

$nomeNovo = bin2hex(random_bytes(16)) . '.' . $tiposPermitidos[$tipoMime];
$caminhoDestino = $pastaUploads . $nomeNovo;
$origem = $arquivo['tmp_name'];

if (!move_uploaded_file($origem, $caminhoDestino)) {
    exit('Não foi possível salvar o comprovante na pasta uploads.');
}

// Registra as vendas no banco usando consulta preparada e transação.
include 'cons.PHP';
if (!$conexao) {
    unlink($caminhoDestino);
    exit('Erro na conexão com o banco de dados.');
}

$numeroVenda = date('YmdHis') . random_int(100, 999);
$usuario = $_SESSION['usuario'];
$dataHora = date('Y-m-d H:i:s');
$total = 0;
$listaProdutos = array();

mysqli_begin_transaction($conexao);
try {
    $stmt = mysqli_prepare($conexao, 'INSERT INTO vendas (Id, NumeroVenda, Usuario, DataHora, Produto, Valor) VALUES (NULL, ?, ?, ?, ?, ?)');
    if (!$stmt) {
        throw new Exception('Não foi possível preparar o registro da venda.');
    }

    foreach ($itensVenda as $item) {
        $produto = $item['produto'];
        $valor = $item['valor'];
        $total += $valor;
        $listaProdutos[] = $produto;
        mysqli_stmt_bind_param($stmt, 'ssssd', $numeroVenda, $usuario, $dataHora, $produto, $valor);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Não foi possível registrar um dos produtos da venda.');
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_commit($conexao);
} catch (Exception $e) {
    mysqli_rollback($conexao);
    mysqli_close($conexao);
    unlink($caminhoDestino);
    error_log('Erro ao registrar venda: ' . $e->getMessage());
    exit('Não foi possível registrar a venda no banco de dados. Confira a tabela vendas e tente novamente.');
}
mysqli_close($conexao);

// Registro simples do upload solicitado no manual (data, nome gerado e tamanho).
$registro = date('Y-m-d H:i:s') . ' | ' . $nomeNovo . ' | ' . (int) $arquivo['size'] . ' bytes' . PHP_EOL;
file_put_contents($pastaUploads . 'registro.txt', $registro, FILE_APPEND | LOCK_EX);

// Envio do e-mail com PHPMailer. A credencial fica fora de htdocs.
$mensagemEmail = 'A venda foi registrada. Configure C:/xampp/config/smtp.php para habilitar o e-mail.';
$caminhoConfiguracao = 'C:/xampp/config/smtp.php';
$autoload = __DIR__ . '/vendor/autoload.php';

if (file_exists($autoload) && file_exists($caminhoConfiguracao)) {
    require_once $autoload;
    $configEmail = require $caminhoConfiguracao;

    if (isset($configEmail['usuario'], $configEmail['senha']) && filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $configEmail['usuario'];
            $mail->Password = $configEmail['senha'];
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom($configEmail['usuario'], 'Canhoto & Belly Outlet');
            $mail->addAddress($usuario);
            $mail->isHTML(true);
            $mail->Subject = 'Confirmação da compra ' . $numeroVenda;

            $produtosHtml = '';
            foreach ($listaProdutos as $nomeProduto) {
                $produtosHtml .= '<li>' . htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') . '</li>';
            }
            $mail->Body = '<h2>Compra registrada com sucesso!</h2>'
                . '<p>Olá, ' . htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8') . '.</p>'
                . '<p>Número da venda: <strong>' . htmlspecialchars($numeroVenda, ENT_QUOTES, 'UTF-8') . '</strong></p>'
                . '<p>Produtos:</p><ul>' . $produtosHtml . '</ul>'
                . '<p>Total: <strong>R$ ' . number_format($total, 2, ',', '.') . '</strong></p>'
                . '<p>Forma de pagamento: ' . htmlspecialchars($pagamento, ENT_QUOTES, 'UTF-8') . '</p>'
                . '<p>Seu comprovante foi recebido.</p>';
            $mail->AltBody = 'Compra ' . $numeroVenda . ' registrada. Total: R$ ' . number_format($total, 2, ',', '.') . '. Pagamento: ' . $pagamento . '.';
            $mail->send();
            $mensagemEmail = 'Uma confirmação foi enviada para ' . $usuario . '. Verifique também a caixa de spam.';
        } catch (Exception $e) {
            error_log('Erro PHPMailer: ' . $mail->ErrorInfo);
            $mensagemEmail = 'A venda foi registrada, mas o e-mail não foi enviado. Confira a configuração SMTP e os logs do PHP.';
        }
    } else {
        $mensagemEmail = 'A venda foi registrada, mas confira o e-mail do cadastro e os campos usuario/senha em smtp.php.';
    }
}

unset($_SESSION['carrinho'], $_SESSION['produto'], $_SESSION['valor']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venda Registrada</title>
    <link rel="stylesheet" href="css/style5.css">
</head>
<body class="center">
    <div class="caixa-formulario">
        <h1>Venda registrada com sucesso!</h1>
        <div class="info"><strong>Número da venda:</strong><br><?php echo htmlspecialchars($numeroVenda, ENT_QUOTES, 'UTF-8'); ?></div>
        <div class="info"><strong>Cliente:</strong><br><?php echo htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8'); ?></div>
        <div class="info"><strong>Produtos:</strong><br>
            <?php foreach ($listaProdutos as $nomeProduto) { echo htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') . '<br>'; } ?>
        </div>
        <div class="info"><strong>Valor Total:</strong><br>R$ <?php echo number_format($total, 2, ',', '.'); ?></div>
        <div class="info"><strong>Pagamento:</strong><br><?php echo htmlspecialchars($pagamento, ENT_QUOTES, 'UTF-8'); ?></div>
        <div class="info"><strong>Comprovante:</strong><br>Arquivo recebido e armazenado com sucesso.</div>
        <p><?php echo htmlspecialchars($mensagemEmail, ENT_QUOTES, 'UTF-8'); ?></p>
        <a href="produtos.php" class="botao">Voltar para Loja</a>
    </div>
</body>
</html>
