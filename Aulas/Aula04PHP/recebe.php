<?php
session_start();
require 'aluno.php';

$nome = $_POST['nome'];
$nascimento = $_POST['nascimento'];
$matricula = $_POST['matricula'];
$curso = $_POST['curso'];

$aluno = new Aluno($nome, $nascimento, $matricula, $curso);

$_SESSION['aluno'] = serialize($aluno);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados Recebidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <h1>Dados do Aluno Cadastrado</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dadosAlunoModal">
            Mostrar
        </button>

       
        <div class="modal fade" id="dadosAlunoModal" tabindex="-1" aria-labelledby="dadosAlunoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dadosAlunoModalLabel">Dados do Aluno</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $aluno = unserialize($_SESSION['aluno']);
                        echo "Nome: {$aluno->nome}<br>";
                        echo "Data de Nascimento: {$aluno->nascimento}<br>";
                        echo "Matrícula: {$aluno->matricula}<br>";
                        echo "Curso: {$aluno->curso}<br>";
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
