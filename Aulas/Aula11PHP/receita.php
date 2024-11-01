<?php
include('conexao.php');

$paciente_id = null;
$paciente_nome = '';

// Verifica se o ID do paciente foi passado
if (isset($_GET['id'])) {
    $paciente_id = $_GET['id'];

    // Busca o nome do paciente
    $resultado = mysqli_query($conn, "SELECT nome FROM pacientes WHERE id = '$paciente_id'");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $paciente = mysqli_fetch_assoc($resultado);
        $paciente_nome = $paciente['nome'];
    }
}

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciente_id = $_POST['paciente_id'];
    $medicamento = $_POST['medicamento'];
    $data_administracao = $_POST['data_administracao'];
    $hora_administracao = $_POST['hora_administracao'];
    $dose = $_POST['dose'];

    $sql = "INSERT INTO receitas (paciente_id, medicamento, data_administracao, hora_administracao, dose) 
            VALUES ('$paciente_id', '$medicamento', '$data_administracao', '$hora_administracao', '$dose')";
    if (mysqli_query($conn, $sql)) {
        header("Location: perfil.php");
        exit();
    } else {
        echo "Erro: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Receita para <?php echo htmlspecialchars($paciente_nome); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/10714/10714002.png" type="image/x-icon">
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
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
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <button class="nav-link btn btn-link" onclick="window.history.back()">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="login-container text-danger">
        <h2>Cadastro de Receita Médica para <span id="nomePaciente"><?php echo htmlspecialchars($paciente_nome); ?></span></h2>
        <form method="POST">
            <div class="form-group">
                <label>Paciente</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <select name="paciente_id" id="pacienteSelect" class="form-control" required onchange="atualizarNomePaciente(this)">
                        <option value="" disabled selected>Selecione um paciente</option>
                        <?php
                        $pacientes = mysqli_query($conn, "SELECT * FROM pacientes");
                        while ($paciente = mysqli_fetch_assoc($pacientes)) {
                            $selected = ($paciente['id'] == $paciente_id) ? 'selected' : '';
                            echo "<option value='" . $paciente['id'] . "' $selected>" . htmlspecialchars($paciente['nome']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Medicamento</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-pills"></i></span>
                    </div>
                    <input type="text" name="medicamento" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Data de Administração</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" name="data_administracao" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Hora de Administração</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                    </div>
                    <input type="time" name="hora_administracao" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Dose</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-syringe"></i></span>
                    </div>
                    <input type="text" name="dose" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Receita</button>
        </form>
    </div>
</div>
<div class="footer mt-auto">
    <p>&copy; 2024 Sistema de Administração de Medicamentos. Todos os direitos reservados.</p>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
        function atualizarNomePaciente(select) {
            const nomePaciente = select.options[select.selectedIndex].text;
            document.getElementById('nomePaciente').innerText = nomePaciente;
            document.title = "Cadastrar Receita para " + nomePaciente;
        }
    </script>
</body>
</html>