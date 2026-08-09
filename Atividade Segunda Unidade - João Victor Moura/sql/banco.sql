CREATE DATABASE IF NOT EXISTS loja_canhoto_belly
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE loja_canhoto_belly;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cpf VARCHAR(20) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(150) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(50) NOT NULL,
    cep VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    cpf VARCHAR(20) NOT NULL,
    CONSTRAINT fk_login_usuario
        FOREIGN KEY (cpf) REFERENCES usuarios(cpf)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_venda VARCHAR(30) NOT NULL,
    usuario VARCHAR(150) NOT NULL,
    produto VARCHAR(150) NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    pagamento VARCHAR(30) DEFAULT NULL,
    data_hora DATETIME NOT NULL
);

-- Exemplo de consulta para visualizar as vendas:
-- SELECT * FROM vendas ORDER BY id DESC;
