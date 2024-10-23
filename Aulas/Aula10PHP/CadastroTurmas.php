<?php
include 'Conexao.php';

if (isset($_POST['cadastrar_turma'])) {
    $nome_turma = $_POST['nome_turma'];
    if (!empty($nome_turma)) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM turmas WHERE nome = ?");
        $stmt->bind_param("s", $nome_turma);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $erro = "A turma '$nome_turma' já está cadastrada.";
        } else {
            $stmt = $conn->prepare("INSERT INTO turmas (nome) VALUES (?)");
            $stmt->bind_param("s", $nome_turma);
            $stmt->execute();
            $stmt->close();
            header("Location: CadastroTurmas.php?secao=aluno"); 
            exit();
        }
    }
}

if (isset($_POST['cadastrar_aluno'])) {
    $nome_aluno = $_POST['nome_aluno'];
    $id_turma = $_POST['id_turma_aluno'];
    if (!empty($nome_aluno) && !empty($id_turma)) {
        $stmt = $conn->prepare("INSERT INTO alunos (nome, id_turma) VALUES (?, ?)");
        $stmt->bind_param("si", $nome_aluno, $id_turma);
        $stmt->execute();
        $stmt->close();
        header("Location: CadastroTurmas.php?secao=nota"); 
        exit();
    }
}

if (isset($_POST['cadastrar_nota'])) {
    $valor_nota = $_POST['valor_nota'];
    $id_aluno_nota = $_POST['id_aluno_nota'];
    $id_turma_nota = $_POST['id_turma_nota'];
    if ($valor_nota >= 0 && $valor_nota <= 10 && !empty($id_aluno_nota) && !empty($id_turma_nota)) {
        $stmt = $conn->prepare("INSERT INTO notas (valor, id_aluno, id_turma) VALUES (?, ?, ?)");
        $stmt->bind_param("dii", $valor_nota, $id_aluno_nota, $id_turma_nota);
        $stmt->execute();
        $stmt->close();
        header("Location: ListarAlunos.php");
        exit();
    }
}

$secao = isset($_GET['secao']) ? $_GET['secao'] : 'turma';

if (isset($_GET['action']) && $_GET['action'] == 'buscar_alunos' && isset($_GET['id_turma'])) {
    $id_turma = $_GET['id_turma'];
    $stmt = $conn->prepare("SELECT id, nome FROM alunos WHERE id_turma = ?");
    $stmt->bind_param("i", $id_turma);
    $stmt->execute();
    $result = $stmt->get_result();

    $alunos = [];
    while ($row = $result->fetch_assoc()) {
        $alunos[] = $row;
    }
    
    echo json_encode($alunos);
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        .form-background {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
    <title>Cadastro</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="">Sistema de Notas</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="?secao=turma"><i class="fas fa-school"></i> Cadastrar Turma</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?secao=aluno"><i class="fas fa-user-graduate"></i> Cadastrar Aluno</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?secao=nota"><i class="fas fa-pencil-alt"></i> Cadastrar Nota</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ListarAlunos.php"><i class="fas fa-list"></i> Listar Alunos e Notas</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <div class="form-background">
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <?php if ($secao == 'turma'): ?>
            <h2><i class="fas fa-school"></i> Cadastrar Turma</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="nome_turma">Nome da Turma:</label>
                    <input type="text" class="form-control" id="nome_turma" name="nome_turma" required>
                </div>
                <button type="submit" name="cadastrar_turma" class="btn btn-primary"><i class="fas fa-plus"></i> Cadastrar Turma</button>
            </form>

        <?php elseif ($secao == 'aluno'): ?>
            <h2><i class="fas fa-user-graduate"></i> Cadastrar Aluno</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="nome_aluno">Nome do Aluno:</label>
                    <input type="text" class="form-control" id="nome_aluno" name="nome_aluno" required>
                </div>
                <div class="form-group">
                    <label for="id_turma_aluno">Selecione a Turma:</label>
                    <select class="form-control" id="id_turma_aluno" name="id_turma_aluno" required>
                        <?php
                        $result = $conn->query("SELECT id, nome FROM turmas");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="cadastrar_aluno" class="btn btn-primary"><i class="fas fa-plus"></i> Cadastrar Aluno</button>
            </form>

        <?php elseif ($secao == 'nota'): ?>
            <h2><i class="fas fa-pencil-alt"></i> Cadastrar Nota</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="valor_nota">Valor da Nota:</label>
                    <input type="number" class="form-control" id="valor_nota" name="valor_nota" min="0" max="10" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="id_turma_nota">Selecione a Turma:</label>
                    <select class="form-control" id="id_turma_nota" name="id_turma_nota" onchange="buscarAlunos(this.value)" required>
                        <option value="">Selecione uma turma</option>
                        <?php
                        $result = $conn->query("SELECT id, nome FROM turmas");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_aluno_nota">Selecione o Aluno:</label>
                    <select class="form-control" id="id_aluno_nota" name="id_aluno_nota" required>
                        <option value="">Selecione uma turma primeiro</option>
                    </select>
                </div>
                <button type="submit" name="cadastrar_nota" class="btn btn-primary"><i class="fas fa-plus"></i> Cadastrar Nota</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> Sistema de Notas. Todos os direitos reservados.</p>
</div>

<script>
function buscarAlunos(turmaId) {
    const alunoSelect = document.getElementById('id_aluno_nota');
    alunoSelect.innerHTML = '<option value="">Carregando...</option>';

    if (turmaId) {
        fetch(`?action=buscar_alunos&id_turma=${turmaId}`)
            .then(response => response.json())
            .then(data => {
                alunoSelect.innerHTML = '<option value="">Selecione um aluno</option>';
                data.forEach(aluno => {
                    alunoSelect.innerHTML += `<option value="${aluno.id}">${aluno.nome}</option>`;
                });
            })
            .catch(error => {
                console.error('Erro ao buscar alunos:', error);
                alunoSelect.innerHTML = '<option value="">Erro ao carregar alunos</option>';
            });
    } else {
        alunoSelect.innerHTML = '<option value="">Selecione uma turma primeiro</option>';
    }
}
</script>

</body>
</html>

<?php
$conn->close();
?>
