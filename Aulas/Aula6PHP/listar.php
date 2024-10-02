<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aula6";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Lista de Usuários</h1>";
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>ID: " . $row["id"] . " - Nome: " . $row["nome"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Nenhum usuário encontrado.";
}

$conn->close();
?>
