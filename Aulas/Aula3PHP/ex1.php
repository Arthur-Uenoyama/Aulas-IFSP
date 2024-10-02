<?php
function calcularJurosSimples($capital, $taxa, $tempo) {
    $juros = $capital * ($taxa / 100) * $tempo;
    return $juros;
}

function calcularJurosCompostos($capital, $taxa, $tempo) {
    $montante = $capital * pow((1 + ($taxa / 100)), $tempo);
    $juros = $montante - $capital;
    return $juros;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $capital = $_POST['capital'];
    $taxa = $_POST['taxa'];
    $tempo = $_POST['tempo'];

    $jurosSimples = calcularJurosSimples($capital, $taxa, $tempo);
    $jurosCompostos = calcularJurosCompostos($capital, $taxa, $tempo);

    echo "Juros Simples: R$ " . number_format($jurosSimples, 2, ',', '.') . "<br>";
    echo "Juros Compostos: R$ " . number_format($jurosCompostos, 2, ',', '.') . "<br>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Calculadora de Juros</title>
</head>
<body>
    <h1>Calculadora de Juros</h1>
    <form method="post" action="">
        <label for="capital">Capital:</label>
        <input type="number" id="capital" name="capital" step="0.01" required><br><br>

        <label for="taxa">Taxa de Juros (%):</label>
        <input type="number" id="taxa" name="taxa" step="0.01" required><br><br>

        <label for="tempo">Tempo (em anos):</label>
        <input type="number" id="tempo" name="tempo" step="0.01" required><br><br>

        <input type="submit" value="Calcular">
    </form>
</body>
</html>
