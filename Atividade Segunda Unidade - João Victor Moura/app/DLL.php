<?php

function teste_login($sessao)
{
    if ($sessao != "ok") {
        header("Location: login.php?erro=login_invalido");
        exit;
    }
}

function banco($server, $user, $password, $db, $consulta)
{
    $banco = new mysqli($server, $user, $password, $db);
    $banco->set_charset("utf8mb4");

    if ($banco->connect_error) {
        die("Falha na conexão com o banco: " . $banco->connect_error);
    }

    $resultado = $banco->query($consulta);

    if (!$resultado) {
        die("Falha na consulta: " . $banco->error);
    }

    $banco->close();
    return $resultado;
}

// Escapa valores antes de colocá-los em consultas SQL.
function limpar($valor)
{
    return addslashes(trim($valor));
}
?>
