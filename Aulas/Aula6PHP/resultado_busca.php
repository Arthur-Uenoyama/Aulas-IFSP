<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aula6";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
o
$nomeBusca = "%" . $_POST['nome'] . "%";

$sql = "SELECT * FROM usuarios WHERE nome LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nomeBusca);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Busca</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Resultados da Busca</h1>
        <?php
        if ($result->num_rows > 0) {
            echo "<ul class='list-group'>";
            while($row = $result->fetch_assoc()) {
                echo "<li class='list-group-item'>ID: " . $row["id"] . " - Nome: " . $row["nome"] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Nenhum usuário encontrado.</p>";
        }
        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
