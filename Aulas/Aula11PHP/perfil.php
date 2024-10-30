<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$tipo_usuario = $_SESSION['tipo_usuario'];

if ($tipo_usuario == "medico") {
    $query = "SELECT * FROM medicos WHERE id = '$usuario_id'";
    $perfil_titulo = "Perfil do Médico"; // Título do perfil para médicos
} else {
    $query = "SELECT * FROM enfermeiros WHERE id = '$usuario_id'";
    $perfil_titulo = "Perfil do Enfermeiro"; // Título do perfil para enfermeiros
}

$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "Usuário não encontrado.";
    exit();
}

// Consulta para buscar pacientes e receitas relacionadas
$query_pacientes = "
    SELECT p.nome AS paciente_nome, p.leito, r.medicamento, r.data_administracao, r.hora_administracao, r.dose
    FROM pacientes p
    LEFT JOIN receitas r ON p.id = r.paciente_id
    WHERE p.id IS NOT NULL;
";
$result_pacientes = mysqli_query($conn, $query_pacientes);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        html, body {
            height: 100%; 
            margin: 0; 
            display: flex; 
            flex-direction: column; 
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
            flex: 1; 
            max-width: 600px;
            margin: 100px auto; 
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
            text-align: center;
        }
        
        .profile-icon {
            font-size: 80px;
            color: #a50d0d;
            margin-bottom: 20px;
        }

        .modal-footer .btn {
            margin-right: 10px; /* Adiciona espaçamento entre os botões */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="home.php">
            <i class="fas fa-hospital me-2"></i> Administração de Medicamentos
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="cadastro_paciente.php">
                        <i class="fas fa-user-plus me-1"></i> Cadastrar Paciente
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="receita.php">
                        <i class="fas fa-prescription-bottle me-1"></i> Cadastrar Receita
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#perfilModal">
                        <i class="fas fa-user-circle" style="font-size: 24px;"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="logout.php">
                        <i class="fas fa-sign-out-alt me-1"></i> Sair
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="perfilModalLabel"><?php echo $perfil_titulo; ?></h5>
                    <br>
                    <a href="editarperfil.php" class="btn btn-warning btn-sm d-flex align-items-center me-1">
                        <i class="fas fa-pencil-alt me-1"></i>
                    </a>
                    <a href="visualizar_receitas.php" class="btn btn-info d-flex align-items-center">
                        <i class="fas fa-eye me-1"></i>
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($user['nome']); ?></p>
                    <?php if ($tipo_usuario == "medico"): ?>
                        <p><strong>Especialidade:</strong> <?php echo htmlspecialchars($user['especialidade']); ?></p>
                        <p><strong>CRM:</strong> <?php echo htmlspecialchars($user['crm']); ?></p>
                    <?php else: ?>
                        <p><strong>COREN:</strong> <?php echo htmlspecialchars($user['coren']); ?></p>
                    <?php endif; ?>
                    <p><strong>Usuário:</strong> <?php echo htmlspecialchars($user['usuario']); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h4><i class="fas fa-users me-2"></i> Pacientes e Receitas</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Leito</th>
                    <th>Medicamento</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Dose</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($paciente = mysqli_fetch_assoc($result_pacientes)) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($paciente['paciente_nome']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['leito']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['medicamento'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($paciente['data_administracao'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($paciente['hora_administracao'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($paciente['dose'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="text-center py-3">
    <p class="mb-0">Administração de Medicamentos - Todos os direitos reservados © 2024</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
