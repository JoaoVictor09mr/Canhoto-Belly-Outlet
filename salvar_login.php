<?php
include "cons.PHP";
require_once "DLL.php";

extract($_POST);

if (!isset($_SESSION))
    session_start();

$cpf = $_SESSION['cpf_cadastro'];

$consulta = "SELECT * FROM usuarios WHERE login = '$login'";

$resultado = banco($server, $user, $password, $db, $consulta);

if ($resultado->num_rows > 0)
{
    header('Location: cadastro2.php?erro=login_existente');
    exit;
}
else
{
    $senha_criptografada = md5($senha);

    $consulta = "UPDATE usuarios SET login = '$login', senha = '$senha_criptografada' WHERE cpf = '$cpf'";

    banco($server, $user, $password, $db, $consulta);

    $_SESSION['Logado'] = 'ok';
    $_SESSION['usuario'] = $login;

    header('Location: produtos.php');
    exit;
}

?>
```
