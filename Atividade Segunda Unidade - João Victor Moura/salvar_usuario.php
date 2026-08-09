<?php
include "app/cons.php";
require_once "app/DLL.php";

if (!isset($_SESSION))
    session_start();

extract($_POST);

if (isset($b2)) {
    $nome = limpar($nome ?? "");
    $cpf = limpar($cpf ?? "");
    $endereco = limpar($endereco ?? "");
    $bairro = limpar($bairro ?? "");
    $cidade = limpar($cidade ?? "");
    $estado = limpar($estado ?? "");
    $cep = limpar($cep ?? "");

    if ($nome == "" || $cpf == "" || $endereco == "" || $bairro == "" ||
        $cidade == "" || $estado == "" || $cep == "") {
        echo "Preencha todos os campos.<br>";
        echo "<a href='cadastro1.php'>Voltar</a>";
        exit;
    }

    $consulta = "SELECT id FROM usuarios WHERE cpf = '$cpf'";
    $resultado = banco($server, $user, $password, $db, $consulta);

    if ($resultado->fetch_assoc()) {
        echo "Usuário já cadastrado.<br>";
        echo "<a href='cadastro1.php'>Voltar</a>";
        exit;
    }

    $consulta = "INSERT INTO usuarios
        (cpf, nome, endereco, bairro, cidade, estado, cep)
        VALUES
        ('$cpf', '$nome', '$endereco', '$bairro', '$cidade', '$estado', '$cep')";

    banco($server, $user, $password, $db, $consulta);

    $_SESSION['cpf_cadastro'] = $cpf;
    $_SESSION['nome_cadastro'] = $nome;

    header('Location: cadastro2.php');
    exit;
}
?>
