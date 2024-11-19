<?php
$host = 'localhost';
$dbname = 'sch';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['nome']) && isset($data['email']) && isset($data['senha'])) {
        $nome = $data['nome'];
        $email = $data['email'];
        $senha = password_hash($data['senha'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$nome, $email, $senha])) {
            echo json_encode(['status' => 'success', 'message' => 'Usuário ' . $nome . ' cadastrado com sucesso!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar usuário.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados inválidos ou incompletos.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro de conexão: ' . $e->getMessage()]);
}
?>
