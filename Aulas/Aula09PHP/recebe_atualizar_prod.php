<?php
$servidor = 'localhost';
$banco = 'loja';
$usuario = 'root';
$senha = '';

$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);


$nome = $_GET['nome'];
$preco = $_GET['precos'];
$url = $_GET['url'];
$descricao = $_GET['descricao'];



echo "Conectado!<br>";



$codigoSQL = "UPDATE `produtos` SET `nome` = :nm, `url` = :urrl, `descricao` = :dsc, `precos` = :prc WHERE `produtos`.`id` = :id";

try {
    $comando = $conexao->prepare($codigoSQL);

    $resultado = $comando->execute(array('nm' => $nome, 'urrl' => $url, 'dsc' => $descricao, 'prc' => $preco, 'id' => $_GET['id']));

    if($resultado) {
	echo "Comando executado!";
    } else {
	echo "Erro ao executar o comando!";
    }
} catch (Exception $e) {
    echo "Erro $e";
}



?>