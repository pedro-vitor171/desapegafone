INSERT INTO marca (nome) VALUES 
('Samsung'),
('Apple'),
('Xiaomi'),
('Motorola'),
('Nokia'),
('Huawei'),
('Sony'),
('Oppo'),
('LG'),
('OnePlus');

INSERT INTO fornecedor (nome, cnpj, telefone, email, endereco, marca_id) VALUES 
('Fornecedor A', '12.345.678/0001-00', 11987654321, 'contato@fornecedora.com', 'Rua A, 123', 1),
('Fornecedor B', '23.456.789/0001-01', 11987654322, 'contato@fornecedorB.com', 'Rua B, 456', 2),
('Fornecedor C', '34.567.890/0001-02', 11987654323, 'contato@fornecedorC.com', 'Rua C, 789', 3),
('Fornecedor D', '45.678.901/0001-03', 11987654324, 'contato@fornecedorD.com', 'Rua D, 101', 4),
('Fornecedor E', '56.789.012/0001-04', 11987654325, 'contato@fornecedorE.com', 'Rua E, 202', 5),
('Fornecedor F', '67.890.123/0001-05', 11987654326, 'contato@fornecedorF.com', 'Rua F, 303', 6),
('Fornecedor G', '78.901.234/0001-06', 11987654327, 'contato@fornecedorG.com', 'Rua G, 404', 7),
('Fornecedor H', '89.012.345/0001-07', 11987654328, 'contato@fornecedorH.com', 'Rua H, 505', 8),
('Fornecedor I', '90.123.456/0001-08', 11987654329, 'contato@fornecedorI.com', 'Rua I, 606', 9),
('Fornecedor J', '01.234.567/0001-09', 11987654330, 'contato@fornecedorJ.com', 'Rua J, 707', 10);

INSERT INTO celulares (nome, marca_id, fornecedor_id, geracao, valor, estoque) VALUES 
('Galaxy S21', 1, 1, 2021, 3499.99, 100),
('iPhone 13', 2, 2, 2021, 4999.99, 150),
('Redmi Note 10', 3, 3, 2021, 1999.99, 200),
('Moto G Power', 4, 4, 2021, 1499.99, 120),
('Nokia 5.4', 5, 5, 2021, 1399.99, 80),
('P40 Pro', 6, 6, 2021, 3999.99, 90),
('Xperia 5 II', 7, 7, 2021, 4299.99, 70),
('Reno 6', 8, 8, 2021, 2299.99, 110),
('LG Velvet', 9, 9, 2021, 2799.99, 60),
('OnePlus 9', 10, 10, 2021, 3299.99, 95);

INSERT INTO usuarios (nome, telefone, email, senha) VALUES 
('João Silva', 11912345678, 'joao.silva@email.com', 'senha123'),
('Maria Oliveira', 11923456789, 'maria.oliveira@email.com', 'senha456'),
('Pedro Santos', 11934567890, 'pedro.santos@email.com', 'senha789'),
('Ana Costa', 11945678901, 'ana.costa@email.com', 'senha101'),
('Carlos Almeida', 11956789012, 'carlos.almeida@email.com', 'senha202'),
('Fernanda Pereira', 11967890123, 'fernanda.pereira@email.com', 'senha303'),
('Lucas Martins', 11978901234, 'lucas.martins@email.com', 'senha404'),
('Juliana Lima', 11989012345, 'juliana.lima@email.com', 'senha505'),
('Rafael Rodrigues', 11990123456, 'rafael.rodrigues@email.com', 'senha606'),
('Patricia Fernandes', 11901234567, 'patricia.fernandes@email.com', 'senha707');

INSERT INTO venda (celular_id, usuario_id, data_venda, valor, quantidade) VALUES 
(1, 1, '2024-09-01', 3499.99, 1),
(2, 2, '2024-09-02', 4999.99, 2),
(3, 3, '2024-09-03', 1999.99, 3),
(4, 4, '2024-09-04', 1499.99, 1),
(5, 5, '2024-09-05', 1399.99, 2),
(6, 6, '2024-09-06', 3999.99, 1),
(7, 7, '2024-09-07', 4299.99, 2),
(8, 8, '2024-09-08', 2299.99, 1),
(9, 9, '2024-09-09', 2799.99, 1),
(10, 10, '2024-09-10', 3299.99, 1);

INSERT INTO adm (nome, cnpj, email, senha) VALUES 
('Admin 1', '12.345.678/0001-00', 'admin1@company.com', 'adminpass1'),
('Admin 2', '23.456.789/0001-01', 'admin2@company.com', 'adminpass2'),
('Admin 3', '34.567.890/0001-02', 'admin3@company.com', 'adminpass3'),
('Admin 4', '45.678.901/0001-03', 'admin4@company.com', 'adminpass4'),
('Admin 5', '56.789.012/0001-04', 'admin5@company.com', 'adminpass5'),
('Admin 6', '67.890.123/0001-05', 'admin6@company.com', 'adminpass6'),
('Admin 7', '78.901.234/0001-06', 'admin7@company.com', 'adminpass7'),
('Admin 8', '89.012.345/0001-07', 'admin8@company.com', 'adminpass8'),
('Admin 9', '90.123.456/0001-08', 'admin9@company.com', 'adminpass9'),
('Admin 10', '01.234.567/0001-09', 'admin10@company.com', 'adminpass10');
