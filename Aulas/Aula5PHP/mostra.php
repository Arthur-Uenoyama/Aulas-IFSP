<?php
session_start();
require_once 'produto.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos Cadastrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Loja</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="mostra.php">Produtos Cadastrados</a>
                    </li>
                </ul>
                <form class="d-flex me-2">
                    <a href="novo.php" class="btn btn-primary">Cadastrar Novo Produto</a>
                </form>
                <form class="d-flex" action="sair.php" method="POST">
                    <button class="btn btn-danger" type="submit">Sair</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="my-4">Produtos Cadastrados</h1>
        <div class="row">
            <?php
            if (isset($_SESSION['produtos']) && !empty($_SESSION['produtos'])) {
                foreach ($_SESSION['produtos'] as $produto_serializado) {
                    $produto = unserialize($produto_serializado);

                    if ($produto instanceof Produto) {
                        echo '<div class="col-md-4 mb-4">';
                        $produto->exibirInformacoes();
                        echo '</div>';
                    } else {
                        echo "Erro ao exibir o produto. O objeto não é da classe Produto.";
                    }
                }
            } else {
                echo "<p>Nenhum produto cadastrado.</p>";
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
