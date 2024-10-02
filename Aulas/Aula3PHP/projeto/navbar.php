<?php
$nome = $_SESSION['nome'] ?? null;
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Meu Site</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="primeira.php">
                        <?php echo $nome ? 'Olá, ' . htmlspecialchars($nome) : 'Entrar'; ?>
                    </a>
                </li>
                <?php if ($nome): ?>
                <li class="nav-item">
                    <a class="nav-link" href="mostrar_nome.php">Mostrar Nome</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="primeira.php">Sair</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
