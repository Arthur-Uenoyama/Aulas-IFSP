<?php
include 'conexao.php';

$delete_conexao = "DELETE FROM futebol WHERE id = :id";
    $stmt = $pdo->prepare($delete_conexao);
    $stmt->execute(['id' => $delete_id]);

    echo "<p>Time apagado com sucesso</p>";
?>