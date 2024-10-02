<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calculadora Simples</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
$pg_atual = isset($_GET['pg']) ? $_GET['pg'] : 'home';

function soma($num1, $num2) {
    return $num1 + $num2;
}

function subtrair($num1, $num2) {
    return $num1 - $num2;
}

$resultado = null;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['num1'], $_GET['num2'], $_GET['operacao'])) {
    $num1 = $_GET['num1'];
    $num2 = $_GET['num2'];
    $operacao = $_GET['operacao'];

    if ($operacao == 'soma') {
        $resultado = soma($num1, $num2);
    } elseif ($operacao == 'subtracao') {
        $resultado = subtrair($num1, $num2);
    }
}
?>

<nav class="navbar navbar-expand-sm bg-body-tertiary mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Matemática</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $pg_atual == 'home' ? 'active' : '' ?>" href="?pg=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $pg_atual == 'soma' ? 'active' : '' ?>" href="?pg=soma">Soma</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $pg_atual == 'subtracao' ? 'active' : '' ?>" href="?pg=subtracao">Subtração</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $pg_atual == 'resultado' ? 'active' : '' ?>" href="#">Resultado</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <?php if ($pg_atual == 'home'): ?>
        <h1>Bem-vindo à Calculadora Simples</h1>
        <p>Escolha uma operação no menu acima.</p>
    <?php elseif ($pg_atual == 'soma'): ?>
        <h1>Calculadora de Soma</h1>
        <form method="get">
            <input type="hidden" name="pg" value="resultado">
            <input type="hidden" name="operacao" value="soma">
            <label for="num1" class="form-label">Número 1:</label>
            <input type="number" id="num1" name="num1" class="form-control" required><br>

            <label for="num2" class="form-label">Número 2:</label>
            <input type="number" id="num2" name="num2" class="form-control" required><br>
            <input type="submit" value="Calcular" class="btn btn-primary">
        </form>
    <?php elseif ($pg_atual == 'subtracao'): ?>
        <h1>Calculadora de Subtração</h1>
        <form method="get">
            <input type="hidden" name="pg" value="resultado">
            <input type="hidden" name="operacao" value="subtracao">
            <label for="num1" class="form-label">Número 1:</label>
            <input type="number" id="num1" name="num1" class="form-control" required><br>

            <label for="num2" class="form-label">Número 2:</label>
            <input type="number" id="num2" name="num2" class="form-control" required><br>
            <input type="submit" value="Subtrair" class="btn btn-primary">
        </form>
    <?php elseif ($pg_atual == 'resultado' && $resultado !== null): ?>
        <h1>Resultado:</h1>
        <p><strong>Resultado da <?= $operacao == 'soma' ? 'soma' : 'subtração' ?>:</strong> <?= $resultado ?></p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
