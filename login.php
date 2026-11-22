<?php
if(!isset($_SESSION))
    session_start();

$erro = "";

if(isset($_GET['erro']))
{
    if($_GET['erro'] == 'login_invalido')
    {
        $erro = "Login ou senha inválidos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="UTF-8">
    <title>Faça o Seu Login:</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style2.css">

</head>
<body>
    <div class="caixa-formulario">
        <p><?php echo $erro; ?></p>
        <h1>Faça o Seu Login:</h1>
        <form action="processa_login.php" method="POST">
            <input type = "text" name ="login" placeholder="Seu login" required>
            <input type = "password" name = "senha" placeholder="Sua senha" required>
            <input class="botao" type="submit" value= "Entrar" name ='b1'>
        </form>
        <p>
            Não possui conta?
            <a href="cadastro1.php">Cadastre-se</a>
        </p>
    </div>
</body>
</html>