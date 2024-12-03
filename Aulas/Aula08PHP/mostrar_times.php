<?php
include('conexao.php');

$conexao = "SELECT * FROM times_futebol";
$stmt = $pdo->query($conexao);
$times = $stmt->fetchAll(PDO::FETCH_ASSOC);