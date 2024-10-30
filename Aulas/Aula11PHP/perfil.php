<?php
session_start();
include('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$tipo_usuario = $_SESSION['tipo_usuario'];

if ($tipo_usuario == "medico") {
    $query = "SELECT * FROM medicos WHERE id = '$usuario_id'";
} else {
    $query = "SELECT * FROM enfermeiros WHERE id = '$usuario_id'";
}

$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Verifica se o usuário foi encontrado
if (!$user) {
    echo "Usuário não encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%; /* Define a altura total do html e body */
            margin: 0; /* Remove margens padrão */
            display: flex; /* Usa flexbox para o layout */
            flex-direction: column; /* Alinha os itens na coluna */
        }

        body {
            background: url('https://www.lucasdorioverde.mt.gov.br/arquivos/noticias/12462/g/pref_lrv.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .navbar, footer {
            background-color: #a50d0d; 
        }

        footer {
            color: white;
        }

        .container {
            flex: 1; /* Faz a div container crescer para ocupar o espaço restante */
            max-width: 600px;
            margin: 100px auto; /* Centraliza a margem */
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
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="text-center mb-4">Perfil do <?php echo $tipo_usuario == "medico" ? "Médico" : "Enfermeiro"; ?></h1>
    <p><strong>Nome:</strong> <?php echo htmlspecialchars($user['nome']); ?></p>
    <?php if ($tipo_usuario == "medico"): ?>
        <p><strong>Especialidade:</strong> <?php echo htmlspecialchars($user['especialidade']); ?></p>
        <p><strong>CRM:</strong> <?php echo htmlspecialchars($user['crm']); ?></p>
    <?php else: ?>
        <p><strong>COREN:</strong> <?php echo htmlspecialchars($user['coren']); ?></p>
    <?php endif; ?>
    <p><strong>Usuário:</strong> <?php echo htmlspecialchars($user['usuario']); ?></p>
    
    <div class="mt-4">
        <h4>Ações</h4>
        <a href="editarperfil.php" class="btn btn-warning w-100">Editar Perfil</a>
        <a href="cadastro_paciente.php" class="btn btn-primary w-100 mb-2">Cadastrar Paciente</a>
        <a href="receita.php" class="btn btn-primary w-100">Cadastrar Receita</a>
    </div>
</div>

<footer class="text-center py-3">
    <p class="mb-0">Administração de Medicamentos - Todos os direitos reservados © 2024</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>

