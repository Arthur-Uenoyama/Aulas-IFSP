<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado do Cadastro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Resultado do Cadastro</h2>
        <div class="alert alert-info">
            <?php
            if (isset($_GET['message'])) {
                echo htmlspecialchars($_GET['message']);
            } else {
                echo "Nenhuma mensagem recebida.";
            }
            ?>
        </div>
        <a href="formulario.php" class="btn btn-primary">Voltar</a>
    </div>
</body>
</html>
