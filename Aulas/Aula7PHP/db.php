<?php
$host = '127.0.0.1:3307'; 
$dbname = 'dbLivros';
$username = 'root'; 
$password = 'usbw'; 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
