<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área da Pizza</title>
</head>
<body>
    <h1>Área da Pizza</h1>

    <form method="post">
        <label for="raio">Raio da Pizza (em cm):</label>
        <input type="number" id="raio" name="raio" step="0.01" required>
        <input type="submit" value="Calcular Área">
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
         
            $raio = $_POST['raio'];
            
          
            if (is_numeric($raio) && $raio > 0) {
              
                $area = pi() * pow($raio, 2);
                
                echo "<p>A área da pizza com raio de $raio cm é: " . number_format($area, 2) . " cm².</p>";
            } else {
                echo "<p>Por favor, insira um valor positivo válido para o raio.</p>";
            }
        }
    ?>
</body>
</html>
