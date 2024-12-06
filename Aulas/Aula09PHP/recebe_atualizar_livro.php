<?php
$servidor = 'localhost';
$banco = 'livros';
$usuario = 'root';
$senha = '';

$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);


$titulo = $_GET['titulo'];
$idioma = $_GET['idioma'];
$editora = $_GET['editora'];
$paginas = $_GET['paginas'];


$codigoSQL = "UPDATE `livros` SET `titulo` = :tit, `idioma` = :idi, `editora` = :ed, `paginas` = :pg WHERE `livros`.`id` = :id";

try {
    $comando = $conexao->prepare($codigoSQL);

    $resultado = $comando->execute(array('tit' => $titulo, 'idi' => $idioma, 'ed' => $editora,'pg' => $paginas, 'id' => $_GET['id']));

    if($resultado) {
	echo "Comando executado!";
    } else {
	echo "Erro ao executar o comando!";
    }
} catch (Exception $e) {
    echo "Erro $e";
}



?>