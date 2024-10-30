<?php
session_start();
include('conexao.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $leito = $_POST['leito'];

    $stmt = $conn->prepare("INSERT INTO pacientes (nome, leito) VALUES (?, ?)");
    $stmt->bind_param("ss", $nome, $leito);

    if ($stmt->execute()) {
        // Redireciona para a página de perfil
        header("Location: perfil.php"); // Ajuste o nome da página conforme necessário
        exit();
    } else {
        $error_message = "Erro ao cadastrar paciente: " . $stmt->error;
    }

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: url('https://www.lucasdorioverde.mt.gov.br/arquivos/noticias/12462/g/pref_lrv.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    
        .navbar {
            background-color: #a50d0d; 
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #a50d0d;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        
        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            margin: auto;
            margin-top: 100px; 
        }
        
        .form-group i {
            color: #a50d0d;
            margin-right: 8px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
    <a class="navbar-brand" href="home.php"><i class="fas fa-hospital"></i> Sistema de Administração de Medicamentos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button class="nav-link btn btn-link" onclick="window.history.back()">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="login-container">
        <h1 class="text-danger mb-4">Cadastrar Paciente</h1>
        <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>
        <form action="cadastro_paciente.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label text-danger">Nome Completo</label>
                <div class="input-group">
                    <label class="input-group-text text-danger" for="nome"><i class="fas fa-user"></i></label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="leito" class="form-label text-danger">Leito</label>
                <div class="input-group">
                    <label class="input-group-text text-danger" for="leito"><i class="fas fa-bed"></i></label>
                    <input type="text" class="form-control" id="leito" name="leito" required>
                </div>
            </div>
            <button type="submit" class="btn btn-danger w-100">Cadastrar Paciente</button>
        </form>
    </div>
</div>

<footer class="footer">
    <p class="mb-0">© 2024 Sistema de Administração de Medicamentos. Todos os direitos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
