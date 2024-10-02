create database receitas;

use receitas;

CREATE TABLE ingredientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    quantidade DECIMAL(10,2) NOT NULL
);

select * from  ingredientes;
