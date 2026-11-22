<?php
if(!isset($_SESSION))
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça Seu Cadastro!</title>
    <link rel="stylesheet" href="css/style3.css">
</head>
<body>
    <div class="conteiner">
        <h1>Faça Seu Cadastro:</h1>
        <p class="subtitulo">
            Crie sua conta:
        </p>
        <form method="POST" action="salvar_usuario.php">
            <input type="text" name="nome" placeholder="Nome Completo" class="campo">
            <input type="text" name="cpf" placeholder="CPF" class="campo">
            <input type="text" name="endereco" placeholder="Endereço" class="campo">
            <input type="text" name="bairro" placeholder="Bairro" class="campo">
            <input type="text" name="cidade" placeholder="Cidade" class="campo">
            <input type="text" name="estado" placeholder="Estado" class="campo">
            <input type="text" name="cep" placeholder="CEP" class="campo campo-final">
            <input type="submit" value="Cadastrar" name="b2" class="botao-cadastrar">

            <p class="texto-login">
                Já possui cadastro?
            </p>
            <a href="login.php" class="botao-login">
                Entrar
            </a>
        </form>
    </div>
</body>
</html>