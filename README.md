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
CREATE DATABASE jv;
USE jv;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(20) NOT NULL UNIQUE,
    endereco VARCHAR(150) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(50) NOT NULL,
    cep VARCHAR(20) NOT NULL,
    login VARCHAR(100) UNIQUE,
    senha VARCHAR(255)
);

CREATE TABLE vendas (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    NumeroVenda VARCHAR(30) NOT NULL,
    Usuario VARCHAR(100) NOT NULL,
    DataHora VARCHAR(30) NOT NULL,
    Produto VARCHAR(100) NOT NULL,
    Valor DECIMAL(10,2) NOT NULL
);
```
MAPA CONCEITUAL // BANCO DE DADOS
<img width="1137" height="642" alt="Image" src="https://github.com/user-attachments/assets/f0339367-52b1-4f8c-bb31-f1eb2bae1bb0" />


MAPA LÓGICO // BANCO DE DADOS
<img width="1145" height="641" alt="Image" src="https://github.com/user-attachments/assets/d8d11e80-1a52-40b2-b030-856790f78b1a" />
