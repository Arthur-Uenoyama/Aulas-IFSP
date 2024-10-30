<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$tipo_usuario = $_SESSION['tipo_usuario'];

// Verifica o filtro selecionado
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'todos';
$leito_selecionado = isset($_GET['leito']) ? $_GET['leito'] : '';

// Consulta para obter os leitos disponíveis
$query_leitos = "SELECT DISTINCT leito FROM pacientes";
$result_leitos = mysqli_query($conn, $query_leitos);
$leitos = mysqli_fetch_all($result_leitos, MYSQLI_ASSOC);

// Adiciona a condição no SQL com base no filtro
$query_pacientes = "
    SELECT p.id AS paciente_id, p.nome AS paciente_nome, p.leito, r.medicamento, r.data_administracao, r.hora_administracao, r.dose
    FROM pacientes p
    LEFT JOIN receitas r ON p.id = r.paciente_id
    WHERE 1=1
";

// Condição para filtrar os pacientes
if ($filtro == 'com_receita') {
    $query_pacientes .= " AND r.paciente_id IS NOT NULL";
} elseif ($filtro == 'sem_receita') {
    $query_pacientes .= " AND r.paciente_id IS NULL";
}

// Filtro por leito
if (!empty($leito_selecionado)) {
    $leito_selecionado = mysqli_real_escape_string($conn, $leito_selecionado);
    $query_pacientes .= " AND p.leito = '$leito_selecionado'";
}

$query_pacientes .= ";";
$result_pacientes = mysqli_query($conn, $query_pacientes);

// Consulta para obter os dados do usuário
if ($tipo_usuario == "medico") {
    $query = "SELECT * FROM medicos WHERE id = '$usuario_id'";
    $perfil_titulo = "Perfil do Médico";
} else {
    $query = "SELECT * FROM enfermeiros WHERE id = '$usuario_id'";
    $perfil_titulo = "Perfil do Enfermeiro"; 
}

$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

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
            max-width: 800px; 
            margin: 100px auto; 
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
            text-align: center;
        }
        
        .profile-icon {
            font-size: 100px; /* Tamanho do ícone */
            color: #a50d0d;   /* Cor do ícone */
        }

        .modal-footer .btn {
            margin-right: 10px;
        }

        table {
            width: 100%; 
            table-layout: auto; 
        }

        th, td {
            padding: 15px; 
            text-align: left; 
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-circle profile-icon"></i>
                    </div>
                    <p><i class="fas fa-user"></i> <strong>Usuário:</strong> <?php echo htmlspecialchars($user['usuario']); ?></p>
                    <p><i class="fas fa-address-card"></i> <strong>Nome:</strong> <?php echo htmlspecialchars($user['nome']); ?></p>
                    <?php if ($tipo_usuario == "medico"): ?>
                        <p><i class="fas fa-stethoscope"></i> <strong>Especialidade:</strong> <?php echo htmlspecialchars($user['especialidade']); ?></p>
                        <p><i class="fas fa-id-card"></i> <strong>CRM:</strong> <?php echo htmlspecialchars($user['crm']); ?></p>
                    <?php else: ?>
                        <p><i class="fas fa-id-badge"></i> <strong>COREN:</strong> <?php echo htmlspecialchars($user['coren']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <h4><i class="fas fa-filter me-2"></i> Filtrar Pacientes</h4>
    <form method="GET" class="mb-4 d-flex justify-content-between">
        <select name="filtro" class="form-select me-2" style="max-width: 200px;" onchange="this.form.submit()">
            <option value="todos" <?php echo $filtro == 'todos' ? 'selected' : ''; ?>>Todos</option>
            <option value="com_receita" <?php echo $filtro == 'com_receita' ? 'selected' : ''; ?>>Com Receita</option>
            <option value="sem_receita" <?php echo $filtro == 'sem_receita' ? 'selected' : ''; ?>>Sem Receita</option>
        </select>
        
        <select name="leito" class="form-select" style="max-width: 200px;" onchange="this.form.submit()">
            <option value="">Selecione o Leito</option>
            <?php foreach ($leitos as $leito) : ?>
                <option value="<?php echo htmlspecialchars($leito['leito']); ?>" <?php echo ($leito_selecionado == $leito['leito']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($leito['leito']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <div class="mt-5">
        <h4><i class="fas fa-users me-2"></i> Pacientes e Receitas</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><i class="fas fa-user-injured"></i> Paciente</th>
                    <th><i class="fas fa-bed"></i> Leito</th>
                    <th><i class="fas fa-pills"></i> Medicamento</th>
                    <th><i class="fas fa-calendar-alt"></i> Data</th>
                    <th><i class="fas fa-clock"></i> Hora</th>
                    <th><i class="fas fa-syringe"></i> Dose</th>
                    <th><i class="fas fa-tools"></i> Ações</th>
                </tr>
            </thead>
            <tbody>
    <?php while ($paciente = mysqli_fetch_assoc($result_pacientes)) : ?>
        <tr>
            <td><?php echo htmlspecialchars($paciente['paciente_nome']); ?></td>
            <td><?php echo htmlspecialchars($paciente['leito']); ?></td>
            <td><?php echo htmlspecialchars($paciente['medicamento'] ?? 'N/A'); ?></td>
            <td>
                <?php
                if (!empty($paciente['data_administracao'])) {
                    $data = DateTime::createFromFormat('Y-m-d', $paciente['data_administracao']);
                    echo htmlspecialchars($data->format('d/m/Y'));
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
            <td>
                <?php
                if (!empty($paciente['hora_administracao'])) {
                    $hora = DateTime::createFromFormat('H:i:s', $paciente['hora_administracao']);
                    echo htmlspecialchars($hora->format('H:i'));
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
            <td><?php echo htmlspecialchars($paciente['dose'] ?? 'N/A'); ?></td>
            <td>
                <?php if (is_null($paciente['medicamento'])): ?>
                    <a href="receita.php?id=<?php echo $paciente['paciente_id']; ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Registrar receita
                    </a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>

        </table>
    </div>
</div>

<footer class="text-center py-3">
    <p class="mb-0">© 2024 Sistema de Administração de Medicamentos. Todos os direitos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
