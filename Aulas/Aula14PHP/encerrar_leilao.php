<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: cadastro_usuario.php');
    exit();
}

$item_id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;

if ($item_id === null) {
    echo "<div class='alert alert-danger'>Item não especificado ou ID inválido.</div>";
    exit;
}

$sql_verifica_item = "SELECT id, nome, dono_id FROM itens WHERE id = ?";
$stmt_verifica_item = mysqli_prepare($conn, $sql_verifica_item);

if (!$stmt_verifica_item) {
    echo "<div class='alert alert-danger'>Erro ao preparar a consulta: " . mysqli_error($conn) . "</div>";
    exit;
}

mysqli_stmt_bind_param($stmt_verifica_item, 'i', $item_id);
mysqli_stmt_execute($stmt_verifica_item);
$result_verifica_item = mysqli_stmt_get_result($stmt_verifica_item);
$item = mysqli_fetch_assoc($result_verifica_item);

if (!$item) {
    echo "<div class='alert alert-danger'>Item não encontrado.</div>";
    exit;
}

$sql_verifica_usuario = "SELECT is_admin FROM usuarios WHERE id = ?";
$stmt_verifica_usuario = mysqli_prepare($conn, $sql_verifica_usuario);

if (!$stmt_verifica_usuario) {
    echo "<div class='alert alert-danger'>Erro ao preparar a consulta: " . mysqli_error($conn) . "</div>";
    exit;
}

mysqli_stmt_bind_param($stmt_verifica_usuario, 'i', $_SESSION['usuario_id']);
mysqli_stmt_execute($stmt_verifica_usuario);
$result_verifica_usuario = mysqli_stmt_get_result($stmt_verifica_usuario);
$usuario = mysqli_fetch_assoc($result_verifica_usuario);

if ($usuario['is_admin'] != 1 && $item['dono_id'] != $_SESSION['usuario_id']) {
    echo "<div class='alert alert-danger'>Você não tem permissão para encerrar este leilão.</div>";
    exit;
}

$sql_maior_lance = "SELECT lances.valor, usuarios.id AS usuario_id
                    FROM lances 
                    JOIN usuarios ON lances.usuario_id = usuarios.id 
                    WHERE lances.item_id = ? 
                    ORDER BY lances.valor DESC 
                    LIMIT 1";
$stmt_maior_lance = mysqli_prepare($conn, $sql_maior_lance);

if (!$stmt_maior_lance) {
    echo "<div class='alert alert-danger'>Erro ao preparar a consulta: " . mysqli_error($conn) . "</div>";
    exit;
}

mysqli_stmt_bind_param($stmt_maior_lance, 'i', $item_id);
mysqli_stmt_execute($stmt_maior_lance);
$result_maior_lance = mysqli_stmt_get_result($stmt_maior_lance);
$maior_lance = mysqli_fetch_assoc($result_maior_lance);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($maior_lance) {
        $vencedor_id = $maior_lance['usuario_id'];
        $sql_encerrar = "UPDATE itens SET estado = 'encerrado', vencedor = ? WHERE id = ?";
        $stmt_encerrar = mysqli_prepare($conn, $sql_encerrar);

        if (!$stmt_encerrar) {
            echo "<div class='alert alert-danger'>Erro ao preparar a consulta: " . mysqli_error($conn) . "</div>";
            exit;
        }

        mysqli_stmt_bind_param($stmt_encerrar, 'ii', $vencedor_id, $item_id);
        if (mysqli_stmt_execute($stmt_encerrar)) {
            echo "<div class='alert alert-success'>Leilão encerrado com sucesso! O vencedor foi o usuário com ID: $vencedor_id.</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao encerrar o leilão: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Não há lances para este item.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encerrar Leilão</title>
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
        <h2>Encerrar Leilão</h2>
        <p><strong>Nome do Item:</strong> <?= htmlspecialchars($item['nome']) ?></p>
        <form method="POST">
            <button type="submit" class="btn btn-danger">Encerrar Leilão</button>
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
