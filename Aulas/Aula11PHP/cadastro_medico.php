<?php
session_start();
include('conexao.php'); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];
    $crm = $_POST['crm'];
    $usuario = $_POST['usuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO medicos (nome, especialidade, crm, usuario, senha) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nome, $especialidade, $crm, $usuario, $senha); 

    if ($stmt->execute()) {
        $_SESSION['usuario_id'] = $conn->insert_id; 
        $_SESSION['tipo_usuario'] = 'medico'; 

        header("Location: perfil.php");
        exit(); 
    } else {
        echo "<div class='alert alert-danger'>Erro ao cadastrar médico: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Médico</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: url('https://www.lucasdorioverde.mt.gov.br/arquivos/noticias/12462/g/pref_lrv.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        
        .navbar, .footer {
            background-color: #a50d0d; 
        }
        
        .footer {
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        
        .container {
            max-width: 500px;
            margin: auto;
        }
        
        .content-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
        }
        
        .form-group i {
            color: #a50d0d;
            margin-right: 8px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="home.php"><i class="fas fa-hospital"></i> Sistema de Administração de Medicamentos</a>
</nav>

<div class="container content-container mt-5">
    <h2 class="text-center text-danger"><i class="fas fa-user-md"></i> Cadastro de Médico</h2>
    <form method="post">
        <div class="form-group">
            <label><i class="fas fa-user"></i> Nome</label>
            <input type="text" class="form-control" name="nome" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-stethoscope"></i> Especialidade</label>
            <select class="form-control" name="especialidade" required>
                <option value="">Selecione a especialidade</option>
                <option value="Cardiologia">Cardiologia</option>
                <option value="Pediatria">Pediatria</option>
                <option value="Neurologia">Neurologia</option>
                <option value="Ortopedia">Ortopedia</option>
                <option value="Ginecologia">Ginecologia</option>
                <option value="Dermatologia">Dermatologia</option>
                <option value="Oncologia">Oncologia</option>
            </select>
        </div>
        <div class="form-group">
            <label><i class="fas fa-id-badge"></i> CRM</label>
            <input type="text" class="form-control" name="crm" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-user"></i> Usuário</label>
            <input type="text" class="form-control" name="usuario" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-lock"></i> Senha</label>
            <input type="password" class="form-control" name="senha" required>
        </div>
        <button type="submit" class="btn btn-danger btn-block">Cadastrar</button>
    </form>
</div>

<div class="footer mt-5">
    <p>&copy; 2024 Sistema de Administração de Medicamentos. Todos os direitos reservados.</p>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?php
mysqli_close($conn);
?>
</body>
</html>
