Loja Belly & JV

A Loja Canhoto & Belly nasceu com a proposta de unir beleza, praticidade e tecnologia em um único espaço. Criada como um projeto de desenvolvimento web, a loja foi pensada para proporcionar aos clientes uma experiência de compra simples, organizada e agradável, desde o cadastro até a escolha dos produtos e a finalização da compra.

A Loja Belly & JV foi desenvolvida como um projeto acadêmico com o objetivo de criar uma experiência de compra online simples e funcional. O site foi construído utilizando PHP, HTML e CSS, com integração ao MySQL para o armazenamento dos dados dos clientes e das vendas. A proposta é simular o funcionamento de uma loja virtual, desde o cadastro do usuário e escolha dos produtos até a confirmação e registro da compra.

Tudo Do Nosso Site <3

. Visualização dos produtos disponíveis na loja e seus respectivos preços

. Sistema de cadastro dividido em duas etapas, com informações pessoais e criação de login e senha

. Área de login, permitindo a autenticação dos usuários cadastrados

. Carrinho de compras, onde é possível adicionar e retirar produtos e acompanhar o preço da compra

. Processo de finalização, com seleção da forma de pagamento e confirmação do pedido

. Armazenamento das vendas realizadas diretamente no banco de dados MySQL

. Uso de sessões para manter as informações do usuário e do carrinho durante a navegação

. Restrição de compra para usuários não autenticados, direcionando o cliente ao login antes de prosseguir com o pedido

//Estrutura De Banco De Dados em SQL

O banco de dados utilizado no projeto foi desenvolvido em MySQL.
📄 [Visualizar código do banco de dados](jv.sql)


Aqui O Script Para A Criação Do Banco no PHP My Admin.
### Código SQL

```sql
CREATE DATABASE Loja;

USE Loja;

CREATE TABLE Carrinho (
    ID_Carrinho INT PRIMARY KEY,
    Nome_Produto VARCHAR(100),
    Valor_Produto DECIMAL(10,2)
);

CREATE TABLE Produtos (
    ID_Produtos INT PRIMARY KEY,
    Nome_Produto VARCHAR(100),
    Valor DECIMAL(10,2),
    Foto_Produto VARCHAR(255),
    Descricao_Produto VARCHAR(255),
    FK_Carrinho_ID_Carrinho INT,
    FOREIGN KEY (FK_Carrinho_ID_Carrinho)
        REFERENCES Carrinho(ID_Carrinho)
);

CREATE TABLE Venda (
    ID_Venda INT PRIMARY KEY,
    NumeroVenda INT,
    Usuario VARCHAR(100),
    Produto VARCHAR(100),
    DataHora DATETIME,
    Valor DECIMAL(10,2),
    Forma_Pagamento VARCHAR(50),
    FK_Produtos_ID_Produtos INT,
    FOREIGN KEY (FK_Produtos_ID_Produtos)
        REFERENCES Produtos(ID_Produtos)
);

CREATE TABLE Usuario (
    ID_Usuario INT PRIMARY KEY,
    Nome VARCHAR(100),
    CPF VARCHAR(14),
    Endereco VARCHAR(150),
    Bairro VARCHAR(100),
    Cidade VARCHAR(100),
    Estado VARCHAR(50),
    CEP VARCHAR(10),
    Login VARCHAR(50),
    Senha VARCHAR(100),
    FK_Venda_ID_Venda INT,
    FOREIGN KEY (FK_Venda_ID_Venda)
        REFERENCES Venda(ID_Venda)
);
```
MAPA CONCEITUAL // BANCO DE DADOS
<img width="1137" height="642" alt="Image" src="https://github.com/user-attachments/assets/f0339367-52b1-4f8c-bb31-f1eb2bae1bb0" />


MAPA LÓGICO // BANCO DE DADOS
<img width="1145" height="641" alt="Image" src="https://github.com/user-attachments/assets/d8d11e80-1a52-40b2-b030-856790f78b1a" />
