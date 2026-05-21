CREATE DATABASE IF NOT EXISTS coser_db;
USE coser_db;

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    categoria VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100) NOT NULL,
    whatsapp VARCHAR(20),
    email VARCHAR(100),
    produtos LONGTEXT,
    total DECIMAL(10, 2),
    forma_pagamento VARCHAR(50),
    status VARCHAR(50) DEFAULT 'Pendente',
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    produto_id INT,
    nome_bebe VARCHAR(100),
    preco_unitario DECIMAL(10, 2),
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
);

INSERT INTO produtos (nome, preco, categoria) VALUES 
('Manta Bordada', 89.90, 'Enxoval'),
('Sapatinho de Lã', 45.00, 'Vestuário'),
('Naninha Personalizada', 55.00, 'Acessórios'),
('Touca com Orelhinhas', 35.00, 'Vestuário'),
('Babador Bandana', 25.00, 'Acessórios'),
('Kit Higiene Tecido', 120.00, 'Quarto');
