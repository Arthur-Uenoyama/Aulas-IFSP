<?php
$servername = '127.0.0.1:3307';
$dbname = 'receitas';
$user = 'root';
$password = 'usbw';

try {
    $conexao = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $user, $password);
    if (isset($_GET['nome']) && isset($_GET['quantidade'])) {
        $nome = $_GET['nome'];
        $quantidade = str_replace(',', '.', $_GET['quantidade']);
        $codigoSQL = "INSERT INTO ingredientes (nome, quantidade) VALUES (:nm, :qtd)";
        $comando = $conexao->prepare($codigoSQL);
        $resultado = $comando->execute(array('nm' => $nome, 'qtd' => $quantidade));

        if ($resultado) {
            echo "Ingrediente inserido com sucesso!";
        } else {
            echo "Erro ao inserir o ingrediente.";
        }
    } else {
        echo "Dados não recebidos.";
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
$conexao = null;

?>
