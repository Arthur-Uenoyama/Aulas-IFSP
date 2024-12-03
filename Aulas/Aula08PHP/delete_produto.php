<?php
    include 'conexao_produtos.php';

    
    $delete_conexao = "DELETE FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($delete_conexao);
    $stmt->execute(['id' => $delete_id]);

    echo "<p>Produto  apagado com sucesso </p>";



?>