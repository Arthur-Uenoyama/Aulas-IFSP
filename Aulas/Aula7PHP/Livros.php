<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Livros</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Cadastro de Livros</h1>
        <form action="process.php" method="post">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="idioma">Idioma:</label>
                <input type="text" class="form-control" id="idioma" name="idioma" required>
            </div>
            <div class="form-group">
                <label for="quantidade_paginas">Quantidade de Páginas:</label>
                <input type="number" class="form-control" id="quantidade_paginas" name="quantidade_paginas" required>
            </div>
            <div class="form-group">
                <label for="editora">Editora:</label>
                <input type="text" class="form-control" id="editora" name="editora" required>
            </div>
            <div class="form-group">
                <label for="data_publicacao">Data da Publicação:</label>
                <input type="date" class="form-control" id="data_publicacao" name="data_publicacao" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Livro</button>
        </form>
    </div>
</body>
</html>
