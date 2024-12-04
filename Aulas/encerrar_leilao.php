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

$sql_maior_lance = "SELECT lances.valor, usuarios.nome, usuarios.id AS usuario_id 
                    FROM lances 
                    JOIN usuarios ON lances.usuario_id = usuarios.id 
                    WHERE lances.item_id = ? 
                    ORDER BY lances.valor DESC 
                    LIMIT 1";
$stmt_maior_lance = mysqli_prepare($conn, $sql_maior_lance);
mysqli_stmt_bind_param($stmt_maior_lance, 'i', $item_id);
mysqli_stmt_execute($stmt_maior_lance);
$result_maior_lance = mysqli_stmt_get_result($stmt_maior_lance);
$maior_lance = mysqli_fetch_assoc($result_maior_lance);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($maior_lance) {
        $vencedor_id = $maior_lance['usuario_id'];
        $sql_encerrar = "UPDATE itens SET estado = 'encerrado', vencedor_id = ? WHERE id = ?";
        $stmt_encerrar = mysqli_prepare($conn, $sql_encerrar);
        mysqli_stmt_bind_param($stmt_encerrar, 'ii', $vencedor_id, $item_id);
        if (mysqli_stmt_execute($stmt_encerrar)) {
            echo "<div class='alert alert-success'>Leilão encerrado com sucesso! O vencedor foi: " . htmlspecialchars($maior_lance['nome']) . ".</div>";
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
</head>
<body>
<div class="container mt-5">
    <h2>Encerrar Leilão - <?= htmlspecialchars($item['nome']) ?></h2>
    <p><strong>Descrição:</strong> <?= htmlspecialchars($item['descricao']) ?></p>
    <p><strong>Estado:</strong> <?= ucfirst($item['estado']) ?></p>
    <?php if ($maior_lance): ?>
        <p><strong>Maior Lance:</strong> R$ <?= number_format($maior_lance['valor'], 2, ',', '.') ?></p>
        <p><strong>Vencedor Atual:</strong> <?= htmlspecialchars($maior_lance['nome']) ?></p>
    <?php else: ?>
        <p><strong>Ainda não há lances para este item.</strong></p>
    <?php endif; ?>
    <form method="POST">
        <button type="submit" class="btn btn-danger">Encerrar Leilão</button>
    </form>
</div>
</body>
</html>
