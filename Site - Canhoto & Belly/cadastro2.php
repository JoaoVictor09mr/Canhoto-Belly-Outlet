<?php
if(!isset($_SESSION))
    session_start();

if(!isset($_SESSION['cpf_cadastro']))
{
    header('Location: cadastro1.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Acesso</title>
    <link rel="stylesheet" href="css/style4.css">
</head>
<body>
    <div class="cartao">
        <h1>Criar Acesso</h1>
        <p>
            Olá,
            <strong><?php echo $_SESSION['nome_cadastro']; ?></strong>

            <br>
            Finalize seu cadastro criando seu login.
        </p>
        
        <?php
        if(isset($_GET['erro']))
        {
            if($_GET['erro'] == 'campos_vazios')
                echo "<div class='erro'>Preencha todos os campos.</div>";

            if($_GET['erro'] == 'senhas_diferentes')
                echo "<div class='erro'>As senhas não coincidem.</div>";

            if($_GET['erro'] == 'login_existente')
                echo "<div class='erro'>Este login já está cadastrado.</div>";
        }
        ?>
        <form method="POST" action="salvar_login.php">
            <div class="input-group">
                <input type="email" name="login" placeholder="Digite seu e-mail" required>
            </div>
            <div class="input-group">
                <input type="password" name="senha" placeholder="Digite sua senha" required>     
            </div>
            <div class="input-group">
                <input type="password" name="senha_conf" placeholder="Confirme sua senha" required>
            </div>
            <button type="submit" name="b1">
                Finalizar Cadastro
            </button>
        </form>
    </div>
</body>
</html>