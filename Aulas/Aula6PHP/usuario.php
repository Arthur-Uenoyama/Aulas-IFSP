<?php
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "aula6";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
$nome = $_POST['nome'];
$sql = "INSERT INTO usuarios (nome) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nome);

if ($stmt->execute()) {
    $result = "Usuário cadastrado com sucesso!";
} else {
    $result = "Erro ao cadastrar usuário: " . $stmt->error;
}
$stmt->close();
$conn->close();

header("Location: resultado.php?message=" . urlencode($result));
exit();
?>
