<?php
session_start();
include('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$tipo_usuario = $_SESSION['tipo_usuario'];

if ($tipo_usuario == "medico") {
    $query = "SELECT * FROM medicos WHERE id = '$usuario_id'";
} else {
    $query = "SELECT * FROM enfermeiros WHERE id = '$usuario_id'";
}

$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Verifica se o usuário foi encontrado
if (!$user) {
    echo "Usuário não encontrado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $usuario = $_POST['usuario'];
    
    if ($tipo_usuario == "medico") {
        $especialidade = $_POST['especialidade'];
        $crm = $_POST['crm'];
        
        // Atualiza os dados do médico
        $update_query = "UPDATE medicos SET nome = '$nome', usuario = '$usuario', especialidade = '$especialidade', crm = '$crm' WHERE id = '$usuario_id'";
    } else {
        $coren = $_POST['coren'];
        
        // Atualiza os dados do enfermeiro
        $update_query = "UPDATE enfermeiros SET nome = '$nome', usuario = '$usuario', coren = '$coren' WHERE id = '$usuario_id'";
    }

    if (mysqli_query($conn, $update_query)) {
        echo "Perfil atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar perfil: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="text-center mb-4">Editar Perfil do <?php echo $tipo_usuario == "medico" ? "Médico" : "Enfermeiro"; ?></h1>
    
    <form method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuário</label>
            <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo htmlspecialchars($user['usuario']); ?>" required>
        </div>
        
        <?php if ($tipo_usuario == "medico"): ?>
            <div class="mb-3">
                <label for="especialidade" class="form-label">Especialidade</label>
                <input type="text" class="form-control" id="especialidade" name="especialidade" value="<?php echo htmlspecialchars($user['especialidade']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="crm" class="form-label">CRM</label>
                <input type="text" class="form-control" id="crm" name="crm" value="<?php echo htmlspecialchars($user['crm']); ?>" required>
            </div>
        <?php else: ?>
            <div class="mb-3">
                <label for="coren" class="form-label">COREN</label>
                <input type="text" class="form-control" id="coren" name="coren" value="<?php echo htmlspecialchars($user['coren']); ?>" required>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-success w-100">Salvar Alterações</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
