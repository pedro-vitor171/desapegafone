create database primer;
use primer;
create table marca (
    id_marca int primary key auto_increment,
    nome varchar(50)
);

create table celulares (
    id_celular int primary key auto_increment,
    nome varchar(100),
    marca_id int,
    geracao int,
    valor float(10,2),
    foreign key (marca_id) references marca(id_marca)
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
