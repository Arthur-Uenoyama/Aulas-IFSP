<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$tipo_usuario = $_SESSION['tipo_usuario'];

if ($tipo_usuario !== "medico" && $tipo_usuario !== "enfermeiro") {
    echo "Acesso negado.";
    exit();
}

$query = "SELECT * FROM receitas WHERE medico_id = '$usuario_id' ORDER BY data_prescricao DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Receitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
            max-width: 900px;
            margin-top: 60px;
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
                    <a class="nav-link" href="perfil.php">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="text-center mb-4">Receitas Cadastradas</h1>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nome do Paciente</th>
                    <th scope="col">Medicamento</th>
                    <th scope="col">Dosagem</th>
                    <th scope="col">Data da Prescrição</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($receita = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($receita['nome_paciente']); ?></td>
                        <td><?php echo htmlspecialchars($receita['nome_medicamento']); ?></td>
                        <td><?php echo htmlspecialchars($receita['dosagem']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($receita['data_prescricao'])); ?></td>
                        <td>
                            <a href="visualizar_receita_detalhes.php?id=<?php echo $receita['id']; ?>" class="btn btn-info btn-sm">Ver Detalhes</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Nenhuma receita cadastrada.</p>
    <?php endif; ?>
</div>

<footer class="text-center py-3">
    <p class="mb-0">Administração de Medicamentos - Todos os direitos reservados © 2024</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
