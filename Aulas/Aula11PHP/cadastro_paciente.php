<?php
session_start();
include('conexao.php'); // Incluindo a conexão ao banco de dados

// Processamento do cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $leito = $_POST['leito'];

    // Prepare a statement
    $stmt = $conn->prepare("INSERT INTO pacientes (nome, leito) VALUES (?, ?)");
    
    // Bind parameters
    $stmt->bind_param("ss", $nome, $leito);

    // Execute the statement
    if ($stmt->execute()) {
        $success_message = "Paciente cadastrado com sucesso!";
    } else {
        $error_message = "Erro ao cadastrar paciente: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('https://www.lucasdorioverde.mt.gov.br/arquivos/noticias/12462/g/pref_lrv.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        
        .container {
            max-width: 500px;
            margin-top: 100px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Administração de Medicamentos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="perfil_medico.php">Meu Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="text-center mb-4">Cadastrar Paciente</h1>
    <?php if (isset($success_message)) echo "<div class='alert alert-success'>$success_message</div>"; ?>
    <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>
    <form action="cadastro_paciente.php" method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="mb-3">
            <label for="leito" class="form-label">Leito</label>
            <input type="text" class="form-control" id="leito" name="leito" required>
        </div>
        <button type="submit" class="btn btn-danger w-100">Cadastrar Paciente</button>
    </form>
</div>

<footer class="text-center py-3 mt-5">
    <p class="mb-0">Administração de Medicamentos - Todos os direitos reservados © 2024</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>