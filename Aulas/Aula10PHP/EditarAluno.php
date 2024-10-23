<?php
include 'Conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT alunos.*, notas.valor AS nota FROM alunos LEFT JOIN notas ON alunos.id = notas.id_aluno WHERE alunos.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $aluno = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $id_turma = $_POST['id_turma'];
    $nota = $_POST['nota']; 
    $sql = "UPDATE alunos SET nome = ?, id_turma = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $nome, $id_turma, $id);
    $stmt->execute();
    $sql_nota = "UPDATE notas SET valor = ? WHERE id_aluno = ?";
    $stmt_nota = $conn->prepare($sql_nota);
    $stmt_nota->bind_param("di", $nota, $id);
    $stmt_nota->execute();

    header('Location: ListarAlunos.php'); 
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
    <title>Editar Aluno</title>
</head>
<body>
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
    <h2>Editar Aluno</h2>
    <div class="form-background">
        <form method="POST" action="">
            <div class="form-group">
                <label for="nome">Nome do Aluno</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($aluno['nome']); ?>" required>
            </div>
            <div class="form-group">
                <label for="id_turma">Turma</label>
                <select class="form-control" id="id_turma" name="id_turma" required>
                    <option value="">Selecione uma turma</option>
                    <?php
                    $turmas_sql = "SELECT * FROM turmas";
                    $turmas_result = $conn->query($turmas_sql);

                    while ($turma = $turmas_result->fetch_assoc()) {
                        $selected = ($turma['id'] == $aluno['id_turma']) ? 'selected' : '';
                        echo "<option value='{$turma['id']}' $selected>{$turma['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nota">Nota</label>
                <input type="number" class="form-control" id="nota" name="nota" value="<?php echo htmlspecialchars($aluno['nota']); ?>" required step="0.1" min="0" max="10">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Salvar
            </button>
            <a href="ListarAlunos.php" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> Sistema de Notas. Todos os direitos reservados.</p>
</div>

</body>
</html>

<?php
$conn->close();
?>
