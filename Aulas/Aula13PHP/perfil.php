<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuarioId'])) {
    header("Location: login.php");
    exit;
}

$usuarioId = $_SESSION['usuarioId'];

// Verificar se o usuário é técnico
$isTecnico = false;
try {
    $stmt = $pdo->prepare("SELECT Id, Nome, Email, Tecnico FROM Usuarios WHERE Id = ?");
    $stmt->execute([$usuarioId]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($usuario && $usuario['Tecnico'] == 1) {
        $isTecnico = true;
    }
} catch (PDOException $e) {
    echo "Erro ao verificar tipo de usuário: " . $e->getMessage();
}

// Carregar os departamentos
$departamentos = [];
try {
    $stmt = $pdo->prepare("SELECT Id, Nome FROM Departamentos");
    $stmt->execute();
    $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao carregar departamentos: " . $e->getMessage();
}

// Carregar os chamados atribuídos ao técnico (se for técnico)
$chamados = [];
try {
    $stmt = $pdo->prepare("SELECT c.Descricao, c.Prioridade, c.ResponsavelId, c.DataCriacao, c.DataHoraLimite, d.Nome AS Departamento, u.Nome AS Responsavel
                           FROM Chamados c
                           LEFT JOIN Departamentos d ON c.DepartamentoId = d.Id
                           LEFT JOIN Usuarios u ON c.ResponsavelId = u.Id
                           WHERE c.ResponsavelId = ?");
    $stmt->execute([$usuarioId]);
    $chamados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao carregar chamados: " . $e->getMessage();
}

$chamadosAbertosCount = count($chamados);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .content {
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
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sistema de Chamados</a>
            <div class="d-flex">
                <a class="btn btn-outline-light" href="cadastro_chamado.php">Abrir Chamado</a>
                <?php if ($isTecnico): ?>
                    <a class="btn btn-outline-light ms-2" href="cadastro_departamento.php">Cadastrar Departamento</a>
                <?php endif; ?>
                <button class="btn btn-outline-light ms-2" data-bs-toggle="modal" data-bs-target="#perfilModal">
                    <i class="fas fa-user"></i>
                </button>
                <a class="btn btn-outline-light ms-2" href="logout.php">Sair</a>
            </div>
        </div>
    </nav>
    <div class="content">
        <div class="container mt-5">
            <?php if (isset($successMessage)): ?>
                <div class="alert alert-success"><?php echo $successMessage; ?></div>
            <?php elseif (isset($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
<hr>
<h3>Chamados Atribuídos</h3>
<?php if (count($chamados) > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Departamento</th>
                <th scope="col">Descrição</th>
                <th scope="col">Prioridade</th>
                <th scope="col">Data de Abertura</th>
                <th scope="col">Data e Hora Limite</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chamados as $chamado): ?>
                <tr>
                    <td><?php echo $chamado['Departamento']; ?></td>
                    <td><?php echo $chamado['Descricao']; ?></td>
                    <td><?php echo $chamado['Prioridade']; ?></td>
                    <td>
                        <?php 
                            echo date('d/m/Y', strtotime($chamado['DataCriacao'])); 
                            echo " - " . date('H:i', strtotime($chamado['DataCriacao'])); 
                        ?>
                    </td>
                    <td>
                        <?php 
                            echo date('d/m/Y', strtotime($chamado['DataHoraLimite'])); 
                            echo " - " . date('H:i', strtotime($chamado['DataHoraLimite'])); 
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Você não tem chamados atribuídos no momento.</p>
<?php endif; ?>

        </div>
    </div>

    <!-- Modal de Perfil -->
<div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="perfilModalLabel">Informações do Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <h5>Nome: <?php echo $usuario['Nome']; ?></h5>
                <p>Email: <?php echo $usuario['Email']; ?></p>
                <p>Perfil: <?php echo $isTecnico ? 'Técnico' : 'Usuário Comum'; ?></p>

                <h6>Chamados Atribuídos: <?php echo $chamadosAbertosCount; ?></h6>

                <?php if ($isTecnico): ?>
                    <h6>Departamentos:</h6>
                    <ul>
                        <?php foreach ($departamentos as $departamento): ?>
                            <li><?php echo $departamento['Nome']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


    <!-- Footer -->
    <footer>
        &copy; 2024 Sistema de Chamados - Todos os direitos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
