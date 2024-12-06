<?php
$servidor = 'localhost';
$banco = 'loja';
$usuario = 'root';
$senha = '';

$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

$nome = $_GET['nome'];
$url = $_GET['link'];
$descricao = $_GET['descricao'];
$preco = $_GET['preco'];


echo "Conectado!<br>";

echo "Recebido: <br>";
echo $_GET['nome'];
echo "<br>";
echo $_GET['link'];
echo "<br>";
echo $_GET['descricao'];
echo "<br>";
echo $_GET['preco'];

$preco = str_replace(',', '.', $preco);

$codigoSQL = "INSERT INTO `produtos` (`id`, `nome`, `url`, `descricao`, `precos`) VALUES (NULL, :nm, :ur, :dsc, :prc)";

try {
    $comando = $conexao->prepare($codigoSQL);

    $resultado = $comando->execute(array('nm' => $nome, 'ur' => $url, 'dsc' => $descricao, 'prc' => $preco));

    if($resultado) {
	echo "Comando executado!";
    } else {
	echo "Erro ao executar o comando!";
    }
} catch (Exception $e) {
    echo "Erro $e";
}

$conexao = null;


?>