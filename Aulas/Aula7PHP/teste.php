<?php
$host = '';
$dbname = '';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conexão realizada com sucesso!";
    $query = $pdo->query("SELECT * FROM tabela_exemplo");
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: " . $row['id'] . " - Nome: " . $row['nome'] . "<br>";
    }
    
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>
