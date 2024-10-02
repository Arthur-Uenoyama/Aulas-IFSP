<?php
$servername = "127.0.0.1:3307";
$username = "root";
$password = "usbw";
$dbname = "dbFutebol";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    $mensagem = ""; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $pontos = $_POST['pontos'];
        $stmt = $conn->prepare("INSERT INTO times (nome, pontos) VALUES (:nome, :pontos)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':pontos', $pontos);

        if ($stmt->execute()) {
            $mensagem = "<div class='alert alert-success'>Time '$nome' cadastrado com sucesso!</div>";
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao cadastrar o time.</div>";
        }
    }
} catch (PDOException $e) {
    $mensagem = "<div class='alert alert-danger'>Falha na conexão: " . $e->getMessage() . "</div>";
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Time de Futebol</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="TimeFutebol.php">Cadastrar Time</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Resultado do Cadastro</h1>
        <?php
        echo $mensagem;
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
