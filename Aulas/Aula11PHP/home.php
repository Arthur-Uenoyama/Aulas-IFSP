<?php
session_start();
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $tipoUsuario = $_POST['tipo_usuario'];
    
    if ($tipoUsuario == "medico") {
        $query = "SELECT * FROM medicos WHERE usuario = '$usuario'";
    } else {
        $query = "SELECT * FROM enfermeiros WHERE usuario = '$usuario'";
    }

    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['tipo_usuario'] = $tipoUsuario;
            header("Location: perfil.php"); 
            exit();
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Medicamentos - Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/10714/10714002.png" type="image/x-icon">
    <style>
        body {
            background: url('https://www.lucasdorioverde.mt.gov.br/arquivos/noticias/12462/g/pref_lrv.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            min-height: 100vh;
        }
    
        .navbar {
            background-color: #a50d0d; 
        }
        
        .footer {
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
        }
        
        .form-group i {
            color: #a50d0d;
            margin-right: 8px;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#"><i class="fas fa-hospital"></i> Sistema de Administração de Medicamentos</a>
</nav>

<div class="container mt-5 login-container">
    <h2 class="text-center text-danger"><i class="fas fa-capsules"></i> Login</h2>
    <?php if (isset($erro)) echo "<div class='alert alert-danger'>$erro</div>"; ?>
    <form method="POST">
        <div class="form-group text-danger">
            <label><i class="fas fa-user"></i> Usuário</label>
            <input type="text" name="usuario" class="form-control" required>
        </div>
        <div class="form-group text-danger">
            <label><i class="fas fa-lock"></i> Senha</label>
            <input type="password" name="senha" class="form-control" required>
        </div>
        <div class="form-group text-danger">
            <label><i class="fas fa-user-md"></i> Tipo de Usuário</label>
            <select name="tipo_usuario" class="form-control">
                <option value="medico">Médico</option>
                <option value="enfermeiro">Enfermeiro</option>
            </select>
        </div>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary mr-2" onclick="window.location.href='cadastro_medico.php'">Registrar Médico</button>
            <button type="button" class="btn btn-primary mr-2" onclick="window.location.href='cadastro_enfermeiro.php'">Registrar Enfermeiro</button>
            <button type="submit" class="btn btn-danger">Entrar</button>
        </div>
    </form>
</div>

<div class="footer mt-auto">
    <p>&copy; 2024 Sistema de Administração de Medicamentos. Todos os direitos reservados.</p>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
