<?php
include "app/cons.php";
require_once "app/DLL.php";

extract($_POST);

if (!isset($_SESSION))
    session_start();

$cpf = $_SESSION['cpf_cadastro'];

$consulta = "SELECT * FROM usuarios WHERE login = '$login'";

$resultado = banco($server, $user, $password, $db, $consulta);

$linha = $resultado->fetch_assoc();

if ($linha)
{
    echo "Este login já está cadastrado.<br>";
    echo "<a href='cadastro2.php'>Voltar</a>";
}
else
{
    $senha_criptografada = md5($senha);

    $consulta = "UPDATE usuarios SET login = '$login', senha = '$senha_criptografada' WHERE cpf = '$cpf'";

    banco($server, $user, $password, $db, $consulta);

    echo "Cadastro realizado com sucesso!<br>";
    echo "<a href='login.php'>Ir para o login</a>";
}
?>
