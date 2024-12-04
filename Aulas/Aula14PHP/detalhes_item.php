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

$sql = "SELECT * FROM itens WHERE id = ? AND estado = 'aberto'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $item_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$item = mysqli_fetch_assoc($result);

if (!$item) {
    echo "<div class='alert alert-danger'>Item não encontrado ou já encerrado.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $valor_lance = $_POST['valor_lance'];
    $usuario_id = $_SESSION['usuario_id'];

    if (is_numeric($valor_lance)) {
        $sql_lance = "SELECT MAX(valor) as maior_lance FROM lances WHERE item_id = ?";
        $stmt_lance = mysqli_prepare($conn, $sql_lance);
        mysqli_stmt_bind_param($stmt_lance, 'i', $item_id);
        mysqli_stmt_execute($stmt_lance);
        $result_lance = mysqli_stmt_get_result($stmt_lance);
        $maior_lance = mysqli_fetch_assoc($result_lance)['maior_lance'];

        if ($valor_lance > $maior_lance) {
            $sql_insert_lance = "INSERT INTO lances (item_id, usuario_id, valor) VALUES (?, ?, ?)";
            $stmt_insert_lance = mysqli_prepare($conn, $sql_insert_lance);
            mysqli_stmt_bind_param($stmt_insert_lance, 'iii', $item_id, $usuario_id, $valor_lance);
            if (mysqli_stmt_execute($stmt_insert_lance)) {
                echo "<div class='alert alert-success'>Lance realizado com sucesso!</div>";
            } else {
                echo "<div class='alert alert-danger'>Erro ao realizar o lance: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>O valor do lance deve ser maior que o lance atual.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>O valor do lance deve ser numérico.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Item</title>
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
    <h2><?= htmlspecialchars($item['nome']) ?></h2>
    <img src="<?= htmlspecialchars($item['imagem']) ?>" class="img-fluid" alt="<?= htmlspecialchars($item['nome']) ?>">
    <p><strong>Lance Mínimo:</strong> R$ <?= number_format($item['minimo'], 2, ',', '.') ?></p>
    <p><strong>Estado:</strong> <?= ucfirst($item['estado']) ?></p>

    <h4>Faça seu Lance:</h4>
    <form method="POST">
        <div class="form-group">
            <label for="valor_lance">Valor do Lance:</label>
            <input type="number" class="form-control" id="valor_lance" name="valor_lance" min="<?= $item['minimo'] + 1 ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Enviar Lance</button>
    </form>

    <?php
    $sql_lance_atual = "SELECT MAX(valor) AS maior_lance FROM lances WHERE item_id = ?";
    $stmt_lance_atual = mysqli_prepare($conn, $sql_lance_atual);
    mysqli_stmt_bind_param($stmt_lance_atual, 'i', $item_id);
    mysqli_stmt_execute($stmt_lance_atual);
    $result_lance_atual = mysqli_stmt_get_result($stmt_lance_atual);
    $maior_lance = mysqli_fetch_assoc($result_lance_atual)['maior_lance'];

    if ($maior_lance) {
        echo "<p><strong>Maior Lance Atual:</strong> R$ " . number_format($maior_lance, 2, ',', '.') . "</p>";
    }
    ?>
</div>

<footer>
    <p>&copy; 2024 Sistema de Leilão. Todos os direitos reservados.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
