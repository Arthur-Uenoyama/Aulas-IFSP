<?php
$servername = "127.0.0.1:3307";
$username = "root";
$password = "usbw";
$dbname = "dbProdutos";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexão falhou: " . $e->getMessage());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $url_foto = $_POST['url_foto'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    try {
        $stmt = $conn->prepare("INSERT INTO produtos (nome, url_foto, descricao, preco) VALUES (:nome, :url_foto, :descricao, :preco)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':url_foto', $url_foto);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':preco', $preco);
        $stmt->execute();
        
        echo "<div class='alert alert-success'>Produto adicionado com sucesso!</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
}
$stmt = $conn->prepare("SELECT * FROM produtos");
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conn = null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Adicionar Produto</h1>
        <form action="AdicionarProduto.php" method="post">
            <div class="form-group">
                <label for="nome">Nome do Produto:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label for="url_foto">URL da Foto:</label>
                <input type="text" class="form-control" id="url_foto" name="url_foto" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" required></textarea>
            </div>

            <div class="form-group">
                <label for="preco">Preço:</label>
                <input type="number" class="form-control" step="0.01" id="preco" name="preco" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Cadastrar Produto</button>
        </form>

        <h2 class="mt-5">Produtos Cadastrados</h2>
        <div class="row">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="<?php echo htmlspecialchars($produto['url_foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                            <p class="card-text"><strong>Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></strong></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
