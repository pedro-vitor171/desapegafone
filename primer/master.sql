create database primer;
use primer;
create table marca (
    id_marca int primary key auto_increment,
    nome varchar(50)
);

CREATE TABLE celulares (
    id_celular INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    marca_id INT,
    geracao INT,
    valor FLOAT(10,2),
    estoque INT,
    FOREIGN KEY (marca_id) REFERENCES marca(id_marca)
);

create table usuarios (
    id_usuario int primary key auto_increment,
    nome varchar(100),
    telefone bigint,
    email varchar(100) unique,
    senha varchar(255)
);

create table venda (
    id_venda int primary key auto_increment,
    celular_id int,
    usuario_id int,
    data_venda date,
    valor float(10,2),
    foreign key (celular_id) references celulares(id_celular),
    foreign key (usuario_id) references usuarios(id_usuario)
);

CREATE TABLE adm (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(18) UNIQUE,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);


INSERT INTO adm (nome, cnpj, email, senha)
VALUES ('Administrador Principal', '12345678901234', 'admin@example.com', 'senha_hash');
