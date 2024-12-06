<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: cadastro_usuario.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$sql_admin = "SELECT is_admin FROM usuarios WHERE id = '$usuario_id'";
$result_admin = mysqli_query($conn, $sql_admin);
$user_data = mysqli_fetch_assoc($result_admin);
$is_admin = $user_data['is_admin'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $minimo = $_POST['minimo'];
    $imagem = $_FILES['imagem']['name'];
    $imagem_temp = $_FILES['imagem']['tmp_name'];
    $caminho_imagem = 'imagens/' . $imagem;

    if (move_uploaded_file($imagem_temp, $caminho_imagem)) {
        $sql = "INSERT INTO itens (nome, imagem, minimo, estado) VALUES ('$nome', '$caminho_imagem', '$minimo', 'aberto')";
        if (mysqli_query($conn, $sql)) {
            echo "<div class='alert alert-success'>Item cadastrado com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao cadastrar o item: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Erro ao enviar a imagem.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Item</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex-grow: 1;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar .navbar-brand {
            color: white !important;
        }

        footer {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="index.php">Leilão</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <?php if (!isset($_SESSION['usuario_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="cadastro_usuario.php">Login</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="itens_abertos.php">Itens Abertos</a>
                </li>
                <?php if (!$is_admin): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="itens_vencidos.php">Itens Vencidos</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h2>Cadastrar Item</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome">Nome do Item:</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="minimo">Lance Mínimo:</label>
            <input type="number" class="form-control" id="minimo" name="minimo" required>
        </div>
        <div class="form-group">
            <label for="imagem">Imagem do Item:</label>
            <input type="file" class="form-control" id="imagem" name="imagem" required>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar Item</button>
    </form>
</div>

<footer>
    <p>&copy; 2024 Sistema de Leilão. Todos os direitos reservados.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
