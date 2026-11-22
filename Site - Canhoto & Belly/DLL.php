<?php
function banco($server, $user, $password, $db, $consulta)
{
    $conexao = mysqli_connect($server, $user, $password, $db);

    if (!$conexao)
    {
        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }

    $resultado = mysqli_query($conexao, $consulta);

    if (!$resultado)
    {
        die("Erro na consulta: " . mysqli_error($conexao));
    }

    mysqli_close($conexao);

    return $resultado;
}
?>
