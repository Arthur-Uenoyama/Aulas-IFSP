<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área da Pizza</title>
</head>
<body>
    <h1>Área da Pizza</h1>
    
    <?php
        $raio = 12;
   
        $area = pi() * pow($raio, 2);
      
        echo "<p>A área da pizza com raio de $raio cm é: " . number_format($area, 2) . " cm².</p>";
    ?>
</body>
</html>
