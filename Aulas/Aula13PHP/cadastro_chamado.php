<?php
session_start();
if (!isset($_SESSION['usuarioId'])) {
    header("Location: login.php");
    exit;
}

include 'conexao.php';

// Carregar os departamentos
try {
    $stmt = $pdo->prepare("SELECT Id, Nome FROM Departamentos");
    $stmt->execute();
    $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar departamentos: " . $e->getMessage());
}

// Carregar os técnicos (usuários com 'Tecnico' = 1)
try {
    $stmt = $pdo->prepare("SELECT Id, Nome FROM Usuarios WHERE Tecnico = 1");
    $stmt->execute();
    $tecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar técnicos: " . $e->getMessage());
}

// Processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
        exit;
    }

    $criadorId = $_SESSION['usuarioId'];
    $departamentoId = $data['departamentoId'];
    $descricao = $data['descricao'];
    $prioridade = $data['prioridade'];
    $dataHoraLimite = $data['dataHoraLimite'];
    $responsavelId = $data['responsavelId']; // ID do técnico responsável

    try {
        // Inserir o chamado no banco de dados
        $stmt = $pdo->prepare("INSERT INTO Chamados (CriadorId, DepartamentoId, Descricao, Prioridade, DataHoraLimite, ResponsavelId) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$criadorId, $departamentoId, $descricao, $prioridade, $dataHoraLimite, $responsavelId]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao abrir chamado: ' . $e->getMessage()]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Chamado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistema de Chamados</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="perfil.php">Voltar para o Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo do Formulário -->
    <div class="content">
        <div class="container mt-5">
            <h1 class="text-center mb-4">Novo Chamado</h1>
            <form id="cadastroChamadoForm" class="p-4 shadow rounded">
                <div class="mb-3">
                    <label for="departamentoId" class="form-label">Departamento:</label>
                    <select id="departamentoId" name="departamentoId" class="form-select" required>
                        <option value="" disabled selected>Selecione um departamento</option>
                        <?php foreach ($departamentos as $departamento): ?>
                            <option value="<?php echo $departamento['Id']; ?>">
                                <?php echo htmlspecialchars($departamento['Nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="prioridade" class="form-label">Prioridade:</label>
                    <select id="prioridade" name="prioridade" class="form-select" required>
                        <option value="Baixa">Baixa</option>
                        <option value="Média">Média</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="dataHoraLimite" class="form-label">Data e Hora Limite:</label>
                    <input type="datetime-local" id="dataHoraLimite" name="dataHoraLimite" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="responsavelId" class="form-label">Técnico Responsável:</label>
                    <select id="responsavelId" name="responsavelId" class="form-select" required>
                        <option value="" disabled selected>Selecione um técnico</option>
                        <?php foreach ($tecnicos as $tecnico): ?>
                            <option value="<?php echo $tecnico['Id']; ?>">
                                <?php echo htmlspecialchars($tecnico['Nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Abrir Chamado</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 Sistema de Chamados - Todos os direitos reservados.
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("cadastroChamadoForm").addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            const response = await fetch("", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data),
            });
            const result = await response.json();
            if (result.success) {
                window.location.href = 'perfil.php';
            } else {
                alert(result.message);
            }
        });
    </script>
</body>
</html>
