CREATE DATABASE primer;
USE primer;

CREATE TABLE marca (
    id_marca INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50)
);

CREATE TABLE fornecedor (
    id_fornecedor INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(18) UNIQUE NOT NULL,
    telefone BIGINT,
    email VARCHAR(100) UNIQUE,
    endereco VARCHAR(255),
    marca_id INT,
    FOREIGN KEY (marca_id) REFERENCES marca(id_marca)
);

CREATE TABLE celulares (
    id_celular INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    marca_id INT,
    fornecedor_id INT,
    geracao INT,
    valor FLOAT(10,2),
    estoque INT,
    FOREIGN KEY (marca_id) REFERENCES marca(id_marca),
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedor(id_fornecedor)
);

CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    telefone BIGINT,
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255)
);

CREATE TABLE venda (
    id_venda INT PRIMARY KEY AUTO_INCREMENT,
    celular_id INT,
    usuario_id INT,
    data_venda DATE,
    valor FLOAT(10,2),
    quantidade INT,
    FOREIGN KEY (celular_id) REFERENCES celulares(id_celular),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario)
);

CREATE TABLE adm (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(18) UNIQUE,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);