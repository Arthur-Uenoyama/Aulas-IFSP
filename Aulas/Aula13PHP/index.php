<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <h2 class="text-center">Cadastro de Usuário</h2>
        <form id="form-cadastro">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('form-cadastro').addEventListener('submit', function(event) {
            event.preventDefault(); 

            const nome = document.getElementById('nome').value;
            const email = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;

            const dados = {
                nome: nome,
                email: email,
                senha: senha
            };

            fetch('cadastro.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dados)
            })
            .then(response => response.json()) 
            .then(data => {
                alert(data.message);
            })
            .catch(error => {
                console.error('Erro ao cadastrar:', error);
                alert('Erro ao cadastrar o usuário.');
            });
        });
    </script>
</body>
</html>
