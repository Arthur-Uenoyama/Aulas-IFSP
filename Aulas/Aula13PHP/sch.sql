
CREATE DATABASE sch ;
USE sch;

CREATE TABLE Usuarios (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    Senha VARCHAR(255) NOT NULL,
    Tecnico BOOLEAN DEFAULT FALSE
);

CREATE TABLE Departamentos (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE Chamados (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    CriadorId INT NOT NULL,
    DepartamentoId INT NOT NULL,
    Descricao TEXT NOT NULL,
    Prioridade ENUM('Baixa', 'Média', 'Alta') NOT NULL,
    ResponsavelId INT,
    DataHoraLimite DATETIME NOT NULL,
    DataCriacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (CriadorId) REFERENCES Usuarios(Id) ON DELETE CASCADE,
    FOREIGN KEY (DepartamentoId) REFERENCES Departamentos(Id) ON DELETE CASCADE,
    FOREIGN KEY (ResponsavelId) REFERENCES Usuarios(Id) ON DELETE SET NULL
);

INSERT INTO Departamentos (Nome) VALUES
('RH'),
('Administracao'),
('Contabilidade'),
('Vendas');
