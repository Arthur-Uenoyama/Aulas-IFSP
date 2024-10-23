CREATE DATABASE sistema_notas;

USE sistema_notas;

CREATE TABLE turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    id_turma INT,
    FOREIGN KEY (id_turma) REFERENCES turmas(id)
);

CREATE TABLE notas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    valor DECIMAL(5, 2) NOT NULL,
    id_aluno INT,
    id_turma INT,
    FOREIGN KEY (id_aluno) REFERENCES alunos(id),
    FOREIGN KEY (id_turma) REFERENCES turmas(id)
);
