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
$sql = "SELECT itens.id, itens.nome, itens.minimo, 
        (SELECT MAX(valor) FROM lances WHERE lances.item_id = itens.id) AS maior_lance 
        FROM itens WHERE estado = 'aberto'";
$result = mysqli_query($conn, $sql);

$sql_vencidos = "SELECT i.id, i.nome 
                 FROM itens i 
                 WHERE i.vencedor = '$usuario_id' AND i.estado = 'encerrado'";
$result_vencidos = mysqli_query($conn, $sql_vencidos);
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
                    <?php if ($is_admin): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="item_lance.php">Cadastrar Item</a>
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
        <h2>Itens Abertos</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Lance Mínimo</th>
                    <th>Maior Lance</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nome']) ?></td>
                        <td>R$ <?= number_format($item['minimo'], 2, ',', '.') ?></td>
                        <td>
                            <?php if ($item['maior_lance']): ?>
                                R$ <?= number_format($item['maior_lance'], 2, ',', '.') ?>
                            <?php else: ?>
                                Nenhum lance
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="detalhes_item.php?id=<?= $item['id'] ?>" class="btn btn-info btn-sm">Ver Detalhes</a>
                            <?php if ($is_admin): ?>
                                <a href="encerrar_leilao.php?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm">Encerrar Leilão</a>
                            <?php endif; ?>
                        </td>
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
