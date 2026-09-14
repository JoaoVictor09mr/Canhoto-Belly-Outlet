<?php
extract($_POST);
if(!isset($_SESSION))
    session_start();

if(isset($adicionar))
{
    if(!isset($_SESSION['carrinho']))
    {
        $_SESSION['carrinho'] = array();
    }
    $_SESSION['carrinho'][] = array(
        "produto" => $produto,
        "valor" => $valor
    );
    header("Location: produtos.php");
    exit;
}

?>