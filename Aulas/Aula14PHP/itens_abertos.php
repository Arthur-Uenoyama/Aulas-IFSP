<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: cadastro_usuario.php');
}

$sql = "SELECT * FROM itens WHERE estado = 'aberto'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itens Abertos</title>
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="index.php">Leilão</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="cadastro_usuario.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="item_lance.php">Cadastrar Item</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="itens_abertos.php">Itens Abertos</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Itens Abertos</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Lance Mínimo</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $item['nome'] ?></td>
                        <td><?= $item['minimo'] ?></td>
                        <td><a href="detalhes_item.php?id=<?= $item['id'] ?>" class="btn btn-info">Ver Detalhes</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Sistema de Leilão. Todos os direitos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
