CREATE DATABASE dbFutebol;

USE dbFutebol;

CREATE TABLE times (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    pontos INT NOT NULL
);

select *from times;