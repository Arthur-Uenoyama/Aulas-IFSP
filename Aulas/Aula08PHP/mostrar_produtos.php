<?php
include 'conexao_produtos.php'
$conexao = "SELECT * FROM produtos";
$stmt = $pdo->query($conexao);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>