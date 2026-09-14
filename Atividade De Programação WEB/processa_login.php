<?php
include "app/cons.php";
require_once "app/DLL.php";

extract($_POST);

if (!isset($_SESSION))
    session_start();

if (isset($b1))
{
    $consulta = "SELECT * FROM usuarios WHERE login = '$login'";

    $resultado = banco($server, $user, $password, $db, $consulta);

    $usuario = $resultado->fetch_assoc();

    if ($usuario)
    {
        $pass = $usuario['senha'];

        if (md5($senha) == trim($pass))
        {
            $_SESSION['Logado'] = 'ok';
            $_SESSION['usuario'] = $login;

            header('Location: produtos.php');
            exit;
        }
    }

    header('Location: login.php?erro=login_invalido');
    exit;
}
?>
