<?php
require 'db.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Cadastro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'];
            $idioma = $_POST['idioma'];
            $quantidade_paginas = $_POST['quantidade_paginas'];
            $editora = $_POST['editora'];
            $data_publicacao = $_POST['data_publicacao'];
            $isbn = $_POST['isbn'];
            $sql = "INSERT INTO livros (titulo, idioma, quantidade_paginas, editora, data_publicacao, isbn) VALUES (:titulo, :idioma, :quantidade_paginas, :editora, :data_publicacao, :isbn)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':idioma', $idioma);
            $stmt->bindParam(':quantidade_paginas', $quantidade_paginas);
            $stmt->bindParam(':editora', $editora);
            $stmt->bindParam(':data_publicacao', $data_publicacao);
            $stmt->bindParam(':isbn', $isbn);

            if ($stmt->execute()) {
                echo "<h1 class='mb-4'>Livro cadastrado com sucesso!</h1>";
                echo "<h2>Detalhes do Livro:</h2>";
                echo "<ul class='list-group mb-4'>";
                echo "<li class='list-group-item'><strong>Título:</strong> $titulo</li>";
                echo "<li class='list-group-item'><strong>Idioma:</strong> $idioma</li>";
                echo "<li class='list-group-item'><strong>Quantidade de Páginas:</strong> $quantidade_paginas</li>";
                echo "<li class='list-group-item'><strong>Editora:</strong> $editora</li>";
                echo "<li class='list-group-item'><strong>Data da Publicação:</strong> $data_publicacao</li>";
                echo "<li class='list-group-item'><strong>ISBN:</strong> $isbn</li>";
                echo "</ul>";
                echo "<a href='Livros.php' class='btn btn-secondary'>Cadastrar outro livro</a>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Erro ao cadastrar o livro.</div>";
            }
        } else {
            echo "<div class='alert alert-warning' role='alert'>Nenhum dado recebido.</div>";
        }
        ?>
    </div>
</body>
</html>
