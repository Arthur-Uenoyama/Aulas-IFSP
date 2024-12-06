<?php
$servidor = 'localhost';
$banco = 'futebol';
$usuario = 'root';
$senha = '';

$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);


$nome = $_GET['nome'];
$pontos = $_GET['pontos'];



echo "Conectado!<br>";

echo "Recebido: <br>";
echo $_GET['nome'];
echo "<br>";
echo $_GET['pontos'];
echo '<br>';


$codigoSQL = "UPDATE `times` SET `nome` = :nm, `pontos` = :ptn WHERE `times`.`id` = :id";

try {
    $comando = $conexao->prepare($codigoSQL);

    $resultado = $comando->execute(array('nm' => $nome, 'ptn' => $pontos, 'id' => $_GET['id']));

    if($resultado) {
	echo "Comando executado!";
    } else {
	echo "Erro ao executar o comando!";
    }
} catch (Exception $e) {
    echo "Erro $e";
}



?>