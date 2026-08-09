<?php
include "app/cons.php";
require_once "app/DLL.php";

if (!isset($_SESSION))
    session_start();

extract($_POST);

if (isset($b1)) {
    $login = limpar($login ?? "");
    $senha = $senha ?? "";
    $senha_conf = $senha_conf ?? "";

    if ($login == "" || $senha == "" || $senha_conf == "") {
        header('Location: cadastro2.php?erro=campos_vazios');
        exit;
    }

    if ($senha != $senha_conf) {
        header('Location: cadastro2.php?erro=senhas_diferentes');
        exit;
    }

    if (!isset($_SESSION['cpf_cadastro'])) {
        header('Location: cadastro1.php');
        exit;
    }

    $consulta = "SELECT id FROM login WHERE usuario = '$login'";
    $resultado = banco($server, $user, $password, $db, $consulta);

    if ($resultado->fetch_assoc()) {
        header('Location: cadastro2.php?erro=login_existente');
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $cpf = limpar($_SESSION['cpf_cadastro']);

    $consulta = "INSERT INTO login (usuario, senha, cpf)
                 VALUES ('$login', '$senhaHash', '$cpf')";

    banco($server, $user, $password, $db, $consulta);

    unset($_SESSION['cpf_cadastro']);
    unset($_SESSION['nome_cadastro']);

    header('Location: login.php');
    exit;
}
?>
