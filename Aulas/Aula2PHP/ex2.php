<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparação de Números</title>
</head>
<body>
    <h1>Comparação de Números</h1>

    <?php
    if (isset($_GET['num1']) && isset($_GET['num2'])) {
        $x = intval($_GET['num1']);
        $y = intval($_GET['num2']);

        echo "<p>Você inseriu: $x e $y</p>";

        // Comparações básicas
        if ($x > $y) {
            echo "<p>$x é maior que $y.</p>";
        } elseif ($x < $y) {
            echo "<p>$y é maior que $x.</p>";
        } else {
            echo "<p>$x é igual a $y.</p>";
        }

        // Verificação de múltiplos
        if ($y != 0 && $x % $y == 0) {
            echo "<p>$x é múltiplo de $y.</p>";
        }

        // Exemplos adicionais com operadores de comparação
        echo "<h2>Exemplos de Operadores de Comparação</h2>";

        // Maior ou igual (>=)
        if ($x >= $y) {
            echo "<p><strong>Operador >=</strong>: $x é maior ou igual a $y.</p>";
        } else {
            echo "<p><strong>Operador >=</strong>: $x não é maior nem igual a $y.</p>";
        }

        // Menor ou igual (<=)
        if ($x <= $y) {
            echo "<p><strong>Operador <=</strong>: $x é menor ou igual a $y.</p>";
        } else {
            echo "<p><strong>Operador <=</strong>: $x não é menor nem igual a $y.</p>";
        }

        // Igual a (==)
        if ($x == $y) {
            echo "<p><strong>Operador ==</strong>: $x é igual a $y.</p>";
        } else {
            echo "<p><strong>Operador ==</strong>: $x não é igual a $y.</p>";
        }

        // Diferente de (!=)
        if ($x != $y) {
            echo "<p><strong>Operador !=</strong>: $x é diferente de $y.</p>";
        } else {
            echo "<p><strong>Operador !=</strong>: $x não é diferente de $y.</p>";
        }

        // Idêntico (===)
        if ($x === $y) {
            echo "<p><strong>Operador ===</strong>: $x é idêntico a $y (mesmo valor e tipo).</p>";
        } else {
            echo "<p><strong>Operador ===</strong>: $x não é idêntico a $y (ou valor ou tipo diferente).</p>";
        }

        // Não idêntico (!==)
        if ($x !== $y) {
            echo "<p><strong>Operador !==</strong>: $x não é idêntico a $y (ou valor ou tipo diferente).</p>";
        } else {
            echo "<p><strong>Operador !==</strong>: $x é idêntico a $y (mesmo valor e tipo).</p>";
        }

        // Espaçonave (<=>)
        $resultado = $x <=> $y;
        if ($resultado === 1) {
            echo "<p><strong>Operador <=>:</strong> $x é maior que $y.</p>";
        } elseif ($resultado === -1) {
            echo "<p><strong>Operador <=>:</strong> $x é menor que $y.</p>";
        } else {
            echo "<p><strong>Operador <=>:</strong> $x é igual a $y.</p>";
        }

    } else {
        echo "<p>Por favor, forneça dois números na URL, por exemplo: ?num1=22&num2=7</p>";
    }
    ?>

    <h2>Insira novos números para comparar</h2>
    <form method="get" action="">
        <label for="num1">Número 1:</label>
        <input type="number" id="num1" name="num1" required>
        <br><br>
        <label for="num2">Número 2:</label>
        <input type="number" id="num2" name="num2" required>
        <br><br>
        <input type="submit" value="Comparar">
    </form>
</body>
</html>
