<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Enfermeiro</title>
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
        
        .navbar, footer {
            background-color: #a50d0d; 
        }
        
        footer {
            color: white;
            margin-top: auto; 
            padding: 10px 0;
            text-align: center; 
        }
        
        .container {
            max-width: 500px;
            margin: auto;
            flex: 1; 
            display: flex;
            flex-direction: column;
            justify-content: center; 
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
    <h2 class="text-center text-danger"><i class="fas fa-user-nurse"></i> Cadastro de Enfermeiro</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label><i class="fas fa-user"></i> Nome Completo</label>
            <input type="text" class="form-control" name="nome" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-id-badge"></i> COREN</label>
            <input type="text" class="form-control" name="coren" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-user"></i> Usuário</label>
            <input type="text" class="form-control" name="usuario" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-lock"></i> Senha</label>
            <input type="password" class="form-control" name="senha" required>
        </div>
        <button type="submit" class="btn btn-danger btn-block">Cadastrar Enfermeiro</button>
    </form>
</div>

<footer class="mt-5">
    <p>&copy; 2024 Sistema de Administração de Medicamentos. Todos os direitos reservados.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>

<?php
mysqli_close($conn);
?>
