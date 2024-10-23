<?php
include 'Conexao.php';
$turmasSql = "SELECT * FROM turmas";
$turmasResult = $conn->query($turmasSql);
$turmas = [];
if ($turmasResult->num_rows > 0) {
    while ($turmaRow = $turmasResult->fetch_assoc()) {
        $turmas[] = $turmaRow;
    }
}

if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $conn->query("DELETE FROM alunos WHERE id = $deleteId");
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Instituto_Federal_de_S%C3%A3o_Paulo_-_Marca_Vertical_2015.svg/200px-Instituto_Federal_de_S%C3%A3o_Paulo_-_Marca_Vertical_2015.svg.png" type="image/x-icon">
    <style>
        body {
            background-image: url('https://c.wallhere.com/photos/45/38/anime_school_Sun-1779177.jpg!d'); 
            background-size: cover;
            background-attachment: fixed;
        }
        .navbar {
            background-color: rgba(0, 123, 255, 0.9); 
        }
        .navbar a {
            color: white !important; 
        }
        .footer {
            background-color: rgba(0, 123, 255, 0.9); 
            color: white;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            width: 100%;
            bottom: 0;
        }
        .container {
            margin-bottom: 60px; 
        }
        .table-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        #loader {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgba(255, 255, 255, 0.8);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 9999;
        }
        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

	.nota-bom {
            color: green;
        }
        .nota-ruim {
            color: red;
        }
    </style>
    <title>Lista Alunos e Notas</title>
</head>
<body>

<div id="loader">
    <div>
        <div class="loader"></div>
        <h2>Carregando suas notas...</h2>
        <p>Aguarde um momento...</p>
        <p>Dicas: Mantenha suas notas organizadas.</p>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#">Sistema de Notas</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="CadastroTurmas.php?secao=turma"><i class="fas fa-school"></i> Cadastrar Turma</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="CadastroTurmas.php?secao=aluno"><i class="fas fa-user-graduate"></i> Cadastrar Aluno</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="CadastroTurmas.php?secao=nota"><i class="fas fa-pencil-alt"></i> Cadastrar Nota</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ListarAlunos.php"><i class="fas fa-list"></i> Listar Alunos e Notas</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h2>Lista de Alunos e Notas</h2>
    
    <form method="GET" class="mb-4">
        <div class="form-row">
            <div class="col-md-4">
                <select name="turma" class="form-control">
                    <option value="">Selecionar turma</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?php echo htmlspecialchars($turma['nome']); ?>" <?php echo (isset($_GET['turma']) && $_GET['turma'] === $turma['nome'] ? 'selected' : ''); ?>>
                            <?php echo htmlspecialchars($turma['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <select name="nota" class="form-control">
                    <option value="">Filtrar por nota</option>
                    <option value="acima" <?php echo (isset($_GET['nota']) && $_GET['nota'] === 'acima' ? 'selected' : ''); ?>>Acima da média (7)</option>
                    <option value="abaixo" <?php echo (isset($_GET['nota']) && $_GET['nota'] === 'abaixo' ? 'selected' : ''); ?>>Abaixo da média (5)</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </div>
        </div>
    </form>

    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Aluno</th>
                    <th>Nome da Turma</th>
                    <th>Nota</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $turma = isset($_GET['turma']) ? $_GET['turma'] : '';
                $notaFiltro = isset($_GET['nota']) ? $_GET['nota'] : '';

                $sql = "SELECT alunos.id, alunos.nome AS aluno_nome, turmas.nome AS turma_nome, notas.valor AS nota
                        FROM alunos
                        LEFT JOIN turmas ON alunos.id_turma = turmas.id
                        LEFT JOIN notas ON alunos.id = notas.id_aluno
                        WHERE 1=1"; 

                if (!empty($turma)) {
                    $sql .= " AND turmas.nome = '$turma'";
                }

                if ($notaFiltro === 'acima') {
                    $sql .= " AND notas.valor >= 7";
                } elseif ($notaFiltro === 'abaixo') {
                    $sql .= " AND notas.valor < 5";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $notaClass = '';
                        if ($row['nota'] !== null) {
                            if ($row['nota'] >= 7) {
                                $notaClass = 'nota-bom'; 
                            } elseif ($row['nota'] < 5) {
                                $notaClass = 'nota-ruim';
                            }
                        }
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['aluno_nome']}</td>
                                <td>{$row['turma_nome']}</td>
                                <td class='{$notaClass}'>" . ($row['nota'] !== null ? $row['nota'] : 'N/A') . "</td>
                                <td>
                                    <a href='EditarAluno.php?id={$row['id']}' class='btn btn-warning btn-sm'><i class='fas fa-pencil-alt'></i>Editar</a>
                                    <a href='?delete_id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir este aluno?\")'> <i class='bi bi-trash'></i> Excluir</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum aluno encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> Sistema de Notas. Todos os direitos reservados.</p>
</div>

<script>
window.onload = function() {
    setTimeout(function() {
        document.getElementById('loader').style.display = 'none';
        document.body.style.overflow = 'auto';
    }, 1500);
};
</script>

</body>
</html>

<?php
$conn->close();
?>
