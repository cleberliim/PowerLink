
-- Criando o banco de dados
CREATE DATABASE IF NOT EXISTS portallog;
USE portallog;

-- Criando a tabela `usuarios`
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserindo dados de exemplo na tabela `usuarios`
INSERT INTO usuarios (nome, email, senha) 
VALUES 
('Cleber Lima', 'cleberliim@outlook.com', '123456'),
('João Silva', 'joao@teste.com', 'abcdef');

-- Criando a tabela `bi`
CREATE TABLE bi (
    id_menu INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserindo dados de exemplo na tabela `bi`
INSERT INTO bi (nome, descricao) 
VALUES 
('Relatório Financeiro', 'Exibe dados financeiros da empresa'),
('Relatório de Vendas', 'Exibe informações sobre vendas realizadas');

-- Criando a tabela `usuario_bi`
CREATE TABLE usuario_bi (
    id_usuario INT NOT NULL,
    id_bi INT NOT NULL,
    PRIMARY KEY (id_usuario, id_bi),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_bi) REFERENCES bi(id_menu) ON DELETE CASCADE
);

-- Inserindo dados de exemplo na tabela `usuario_bi`
INSERT INTO usuario_bi (id_usuario, id_bi) 
VALUES 
(1, 1), -- Cleber tem acesso ao Relatório Financeiro
(1, 2), -- Cleber tem acesso ao Relatório de Vendas
(2, 2); -- João tem acesso apenas ao Relatório de Vendas
