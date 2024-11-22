<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];

    try {
        $stmt = $pdo->prepare("INSERT INTO Departamentos (Nome) VALUES (?)");
        $stmt->execute([$nome]);
        $sucesso = "Departamento cadastrado com sucesso!";
    } catch (PDOException $e) {
        $erro = "Erro ao cadastrar departamento: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Departamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }

        .container {
            flex: 1;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }
    </style>
</head>
<body class="d-flex flex-column">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sistema de Chamados</a>
            <div class="d-flex">
                <a class="btn btn-outline-light" href="perfil.php">Voltar para o Perfil</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Cadastro de Departamento</h1>
        <form method="POST" class="p-4 shadow rounded mx-auto" style="max-width: 400px;">
            <?php if (isset($sucesso)): ?>
                <div class="alert alert-success" role="alert"><?php echo $sucesso; ?></div>
            <?php elseif (isset($erro)): ?>
                <div class="alert alert-danger" role="alert"><?php echo $erro; ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Departamento:</label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
        </form>
    </div>

    <footer>
        &copy; 2024 Sistema de Chamados - Todos os direitos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
