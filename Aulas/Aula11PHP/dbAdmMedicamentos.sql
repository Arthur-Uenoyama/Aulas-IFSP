CREATE DATABASE dbAdministracaoMedicamentos;

USE dbAdministracaoMedicamentos;

CREATE TABLE medicos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    especialidade ENUM('Cardiologia', 'Pediatria', 'Neurologia', 'Ortopedia', 'Ginecologia', 'Dermatologia', 'Oncologia'),
    crm VARCHAR(20),
    usuario VARCHAR(50) UNIQUE,
    senha VARCHAR(255)
);

CREATE TABLE enfermeiros (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    coren VARCHAR(20),
    usuario VARCHAR(50) UNIQUE,
    senha VARCHAR(255)
);

CREATE TABLE pacientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    leito VARCHAR(50)
);

CREATE TABLE receitas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    paciente_id INT,
    medicamento VARCHAR(100),
    data_administracao DATE,
    hora_administracao TIME,
    dose VARCHAR(50),
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
);

CREATE TABLE administracoes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    receita_id INT,
    data_registro DATETIME,
    FOREIGN KEY (receita_id) REFERENCES receitas(id)
);
