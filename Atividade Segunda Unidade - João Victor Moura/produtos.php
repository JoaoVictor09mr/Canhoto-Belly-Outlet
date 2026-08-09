<?php

if(!isset($_SESSION))
    session_start();

$quantidade = 0;

if(isset($_SESSION['carrinho']))
{
    $quantidade = count($_SESSION['carrinho']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canhoto & Belly Outlet</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/style6.css">
</head>
<body>
    <nav class="barra-navegacao">
        <div class="logotipo">
            Canhoto & Belly
        </div>
        <div class="menu">
            <a href="#">Início</a>
            <a href="#">Produtos</a>
            <a href="#">Promoções</a>
            <a href="#">Contato</a>
            <a href="historico_vendas.php">Minhas compras</a>
        </div>
        <a href="ver_carrinho.php" class="cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <div class="contador">
                 <?php echo $quantidade; ?>
            </div>
        </a>
    </nav>
    <div class="conteudo">
        <h1>Canhoto & Belly Outlet</h1>
        <div class="vitrine">
            <div class="cartao">
                <form action="confirmar.php" method="POST">
                    <img src="img/imagemcamisabranca.jpg" alt="Camiseta Branca">
                    <p class="nome">Camiseta Branca</p>
                    <p class="preco">R$ 49,90</p>
                    <input type="hidden" name="produto" value="Camiseta Branca">
                    <input type="hidden" name="valor" value="49,90">
                    <button type="submit">
                        Comprar
                    </button>
                </form>
                <form action="carrinho.php" method="POST">
                    <input type="hidden" name="produto" value="Camiseta Branca">
                    <input type="hidden" name="valor" value="49.90">
                    <button type="submit" name="adicionar">
                        Adicionar ao Carrinho
                </button>
                </form>
            </div>
            <div class="cartao">
                <form action="confirmar.php" method="POST">
                    <img src="img/camisa-social-manga-curta.jpg" alt="Camisa Manga Curta">
                    <p class="nome">Camisa Manga Curta</p>
                    <p class="preco">R$ 89,90</p>
                    <input type="hidden" name="produto" value="Camisa Manga Curta">
                    <input type="hidden" name="valor" value="89,90">
                    <button type="submit">
                        Comprar
                    </button>
                </form>
                <form action="carrinho.php" method="POST">
                    <input type="hidden" name="produto" value="Camisa Manga Curta">
                    <input type="hidden" name="valor" value="89.90">
                    <button type="submit" name="adicionar">
                        Adicionar ao Carrinho
                </button>
                </form>
            </div>
            <div class="cartao">
                <form action="confirmar.php" method="POST">
                    <img src="img/camisapreta.jpg" alt="Camiseta Preta">
                    <p class="nome">Camiseta Preta</p>
                    <p class="preco">R$ 49,90</p>
                    <input type="hidden" name="produto" value="Camiseta Preta">
                    <input type="hidden" name="valor" value="49,90">
                    <button type="submit">
                        Comprar
                    </button>
                </form>
                <form action="carrinho.php" method="POST">
                    <input type="hidden" name="produto" value="Camiseta Preta">
                    <input type="hidden" name="valor" value="49.90">
                    <button type="submit" name="adicionar">
                        Adicionar ao Carrinho
                </button>
                </form>
            </div>
            <div class="cartao">
                <form action="confirmar.php" method="POST">
                    <img src="img/jaqueta-branca.jpg" alt="Jaqueta Branca">
                    <p class="nome">Jaqueta Branca</p>
                    <p class="preco">R$ 159,90</p>
                    <input type="hidden" name="produto" value="Jaqueta Branca">
                    <input type="hidden" name="valor" value="159,90">
                    <button type="submit">
                        Comprar
                    </button>
                </form>
                <form action="carrinho.php" method="POST">
                    <input type="hidden" name="produto" value="Jaqueta Branca">
                    <input type="hidden" name="valor" value="159.90">
                    <button type="submit" name="adicionar">
                        Adicionar ao Carrinho
                </button>
                </form>
            </div>
            <div class="cartao">
                <form action="confirmar.php" method="POST">
                    <img src="img/selecao.jpg" alt="Camisa Seleção">
                    <p class="nome">Camisa Seleção</p>
                    <p class="preco">R$ 119,90</p>
                    <input type="hidden" name="produto" value="Camisa Seleção">
                    <input type="hidden" name="valor" value="119,90">
                    <button type="submit">
                        Comprar
                    </button>
                </form>
                <form action="carrinho.php" method="POST">
                    <input type="hidden" name="produto" value="Camiseta Seleção">
                    <input type="hidden" name="valor" value="119.90">
                    <button type="submit" name="adicionar">
                        Adicionar ao Carrinho
                </button>
                </form>
            </div>
            <div class="cartao">
                <form action="confirmar.php" method="POST">
                    <img src="img/xadrez.jpg" alt="Camisa Xadrez">
                    <p class="nome">Camisa Xadrez</p>
                    <p class="preco">R$ 79,90</p>
                    <input type="hidden" name="produto" value="Camisa Xadrez">
                    <input type="hidden" name="valor" value="79,90">
                    <button type="submit">
                        Comprar
                    </button>
                </form>
                <form action="carrinho.php" method="POST">
                    <input type="hidden" name="produto" value="Camiseta Xadrez">
                    <input type="hidden" name="valor" value="79.90">
                    <button type="submit" name="adicionar">
                        Adicionar ao Carrinho
                </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>