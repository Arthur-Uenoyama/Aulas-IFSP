<?php
session_start();
require 'aluno.php';
$aluno = unserialize($_SESSION['aluno']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <h1>Dados do Aluno</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nome: <?= $aluno->nome ?></h5>
                <p class="card-text">Data de Nascimento: <?= $aluno->nascimento ?></p>
                <p class="card-text">Matrícula: <?= $aluno->matricula ?></p>
                <p class="card-text">Curso: <?= $aluno->curso ?></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
