create database primer;
use primer;
create table marca( nome varchar(50) primary key);

create table celulares (
    nome varchar(100), 
    marca varchar(50), 
    geração int, 
    valor float(10,2),
    primary key (nome, marca),
    foreign key (marca) references marca(nome)
);

create table usuários (
    nome varchar(100), 
    telefone int, 
    email varchar(100), 
    password varchar(25),
    primary key(email)
);

create table venda (
    produto varchar(100), 
    comprador varchar(150), 
    data date, 
    valor float(10,2),
    primary key (produto),
    foreign key (produto) references celulares(nome) -- Corrigido
);
