<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $peso = filter_var($_POST['peso'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $altura = filter_var($_POST['altura'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    if (filter_var($peso, FILTER_VALIDATE_FLOAT) === false || filter_var($altura, FILTER_VALIDATE_FLOAT) === false || $altura <= 0) {
        $error = "Por favor, insira valores válidos para peso e altura.";
    } else {
        $imc = $peso / ($altura * $altura);

        if ($imc < 18.5) {
            $classificacao = "Abaixo do peso";
        } elseif ($imc >= 18.5 && $imc < 24.9) {
            $classificacao = "Peso normal";
        } elseif ($imc >= 25 && $imc < 29.9) {
            $classificacao = "Sobrepeso";
        } else {
            $classificacao = "Obesidade";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de IMC</title>
</head>
<body>
    <h1>Calculadora de IMC</h1>
    <form method="post" action="">
        <label for="peso">Peso (kg):</label>
        <input type="text" id="peso" name="peso" required>
        <br><br>
        <label for="altura">Altura (m):</label>
        <input type="text" id="altura" name="altura" required>
        <br><br>
        <input type="submit" value="Calcular IMC">
    </form>

    <?php
    if (isset($imc)) {
        echo "<h2>Resultado:</h2>";
        echo "<p>Seu IMC é: " . number_format($imc, 2) . "</p>";
        echo "<p>Classificação: " . $classificacao . "</p>";
    }

    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
</body>
</html>
