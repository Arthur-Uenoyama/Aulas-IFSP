<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <h1>Cadastro de Aluno</h1>
        <form action="recebe.php" method="POST">
            <div class="row mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="row mb-3">
                <label for="nascimento" class="form-label">Data de Nascimento:</label>
                <input type="date" class="form-control" id="nascimento" name="nascimento" required>
            </div>
            <div class="row mb-3">
                <label for="matricula" class="form-label">Matrícula:</label>
                <input type="text" class="form-control" id="matricula" name="matricula" required>
            </div>
            <div class="row mb-3">
                <label for="curso" class="form-label">Curso:</label>
                <input type="text" class="form-control" id="curso" name="curso" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
