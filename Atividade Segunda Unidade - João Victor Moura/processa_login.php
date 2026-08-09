<?php
include "app/cons.php";
require_once "app/DLL.php";

if (!isset($_SESSION))
    session_start();

extract($_POST);

if (isset($b1)) {
    $login = limpar($login ?? "");
    $senha = $senha ?? "";

    $consulta = "SELECT usuario, senha, cpf
                 FROM login
                 WHERE usuario = '$login'";

    $resultado = banco($server, $user, $password, $db, $consulta);
    $linha = $resultado->fetch_assoc();

    if ($linha && password_verify($senha, $linha['senha'])) {
        $_SESSION['Logado'] = 'ok';
        $_SESSION['usuario'] = $linha['usuario'];
        $_SESSION['cpf'] = $linha['cpf'];

        header('Location: produtos.php');
        exit;
    }

    header('Location: login.php?erro=login_invalido');
    exit;
}
?>
