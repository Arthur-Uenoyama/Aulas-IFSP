create database dbLivros;

use dbLivros;

CREATE TABLE livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    idioma VARCHAR(100) NOT NULL,
    quantidade_paginas INT NOT NULL,
    editora VARCHAR(255) NOT NULL,
    data_publicacao DATE NOT NULL,
    isbn VARCHAR(20) NOT NULL
);
