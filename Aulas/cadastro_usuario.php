<?php
session_start();
include 'conexao.php'; // Inclui o arquivo de conexão

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cadastrar'])) {
        // Escapar valores para evitar SQL Injection
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $senha = mysqli_real_escape_string($conn, $_POST['senha']);
        $confirmar_senha = mysqli_real_escape_string($conn, $_POST['confirmar_senha']);

        // Verificar se as senhas são iguais
        if ($senha !== $confirmar_senha) {
            $erro = "As senhas não coincidem.";
        } else {
            // Criptografar a senha
            $senha_criptografada = hash('sha256', $senha);

            // Verificar se o email já está cadastrado
            $sql = "SELECT * FROM usuarios WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $erro = "Este e-mail já está cadastrado.";
            } else {
                // Inserir novo usuário no banco
                $sql_insert = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha_criptografada')";
                if (mysqli_query($conn, $sql_insert)) {
                    // Efetuar login automaticamente após cadastro
                    $sql_login = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha_criptografada'";
                    $result_login = mysqli_query($conn, $sql_login);

                    if (mysqli_num_rows($result_login) > 0) {
                        $usuario = mysqli_fetch_assoc($result_login);
                        $_SESSION['usuario_id'] = $usuario['id'];
                        $_SESSION['usuario'] = $usuario['nome'];
                        header('Location: item_lance.php'); // Redireciona para página de itens
                        exit;
                    } else {
                        $erro = "Erro ao fazer login após cadastro.";
                    }
                } else {
                    $erro = "Erro ao cadastrar usuário: " . mysqli_error($conn);
                }
            }
        }
    } elseif (isset($_POST['login'])) {
        // Realizar login
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $senha = mysqli_real_escape_string($conn, $_POST['senha']);

        // Criptografar a senha
        $senha_criptografada = hash('sha256', $senha);

        // Verificar login
        $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha_criptografada'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $usuario = mysqli_fetch_assoc($result);
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario'] = $usuario['nome'];
            header('Location: item_lance.php'); // Redireciona para página de itens
            exit;
        } else {
            $erro = "E-mail ou senha inválidos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro e Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #007bff;
        }
        .navbar .navbar-nav .nav-link {
            color: white !important;
        }
        .navbar .navbar-brand {
            color: white !important;
        }
        footer {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
            display: flex;
            justify-content: center;
            height: 100vh;
            flex-direction: column;
        }
        .form-container {
            display: flex;
            flex: 1;
            width: 200%;
            transition: transform 0.5s ease-in-out;
        }

        .form-section {
            width: 50%;
            padding: 20px;
            display: none;
            height: 100%;
        }

        .form-section.active {
            display: block;
        }
        .form-group {
            margin-bottom: 1rem;
        }

        .btn-block {
            width: 100%;
        }
        .form-container {
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="index.php">Leilão</a>
    </nav>
    <div class="container">
        <div class="form-container">
            <div class="form-section cadastro active">
                <h2>Cadastro de Usuário</h2>
                
                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger"><?= $erro ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmar_senha">Confirmar Senha:</label>
                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="cadastrar">Cadastrar</button>
                </form>
                <p class="mt-3 text-center">Já tem uma conta? <a href="javascript:void(0)" class="toggle-form" data-target=".login">Faça login</a></p>
            </div>
            <div class="form-section login">
                <h2>Login</h2>
                
                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger"><?= $erro ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="login">Entrar</button>
                </form>
                <p class="mt-3 text-center">Ainda não tem uma conta? <a href="javascript:void(0)" class="toggle-form" data-target=".cadastro">Cadastre-se</a></p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Sistema de Leilão. Todos os direitos reservados.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.toggle-form').on('click', function() {
                var target = $(this).data('target');
                var currentIndex = $('.form-section.active').index();
                var targetIndex = $(target).index();
                if (currentIndex === targetIndex) return;
                var direction = currentIndex < targetIndex ? '-100%' : '100%';
                $('.form-container').css('transform', 'translateX(' + direction + ')');
                setTimeout(function() {
                    $('.form-section').removeClass('active');
                    $(target).addClass('active');
                    $('.form-container').css('transform', 'translateX(0)');
                }, 500);
            });
        });
    </script>
</body>
</html>
