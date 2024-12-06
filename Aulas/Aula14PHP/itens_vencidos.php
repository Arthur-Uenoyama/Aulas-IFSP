<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: cadastro_usuario.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT * FROM itens WHERE vencedor = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itens Vencidos</title>
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
                <?php if (!isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastro_usuario.php">Login</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="itens_abertos.php">Itens Abertos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="itens_vencidos.php">Itens Vencidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Itens Vencidos</h2>
        <?php if ($result->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($item = $result->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($item['nome']) ?></strong> - 
                        Lance Mínimo: R$ <?= number_format($item['minimo'], 2, ',', '.') ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Você ainda não venceu nenhum leilão.</p>
        <?php endif; ?>
    </div>
    <footer>
        <p>&copy; 2024 Sistema de Leilão. Todos os direitos reservados.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
