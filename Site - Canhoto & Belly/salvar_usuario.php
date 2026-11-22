<?php
include "cons.PHP";
require_once "DLL.php";

extract($_POST);

if (!isset($_SESSION))
    session_start();

$consulta = "SELECT * FROM usuarios WHERE cpf = '$cpf'";

$resultado = banco($server, $user, $password, $db, $consulta);

$linha = $resultado->fetch_assoc();

if ($linha)
{
    echo "Usuário já cadastrado.<br>";
    echo "<a href='cadastro1.php'>Voltar</a>";
}
else
{
    $consulta = "INSERT INTO usuarios (nome, cpf, endereco, bairro, cidade, estado, cep) VALUES ('$nome', '$cpf', '$endereco', '$bairro', '$cidade', '$estado', '$cep')";

    banco($server, $user, $password, $db, $consulta);

    $_SESSION['cpf_cadastro'] = $cpf;
    $_SESSION['nome_cadastro'] = $nome;

    header('Location: cadastro2.php');
    exit;
}
?>
