<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Times de Futebol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Cadastro de Time</h3>
                    </div>
                    <div class="card-body">
                        <form action="SalvarTime.php" method="POST">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Time</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do time" required>
                            </div>
                            <div class="mb-3">
                                <label for="pontos" class="form-label">Pontos</label>
                                <input type="number" class="form-control" id="pontos" name="pontos" placeholder="Digite a pontuação" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Salvar Time</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
