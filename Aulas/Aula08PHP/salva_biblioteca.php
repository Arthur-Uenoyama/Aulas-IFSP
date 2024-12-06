<?php
include("conexao.php");

echo "Conectado!<br>";

echo "Recebido: <br>";
echo $_GET['titulo'];
echo "<br>";
echo $_GET['editora'];

$codigoSQL = "INSERT INTO `livros` (`id`, `titulo`, `idioma`, `editora`, `paginas`, `publicacao`, `isbn`) VALUES (NULL, :tit, :id, :ed, :pag, :pub, :isbn)";


try {
    $comando = $conexao->prepare($codigoSQL);

    $resultado = $comando->execute(array('tit' => $titulo, 'id' => $idioma, 'ed' => $editora, 'pag' => $paginas, 'pub' => $data, 'isbn' => $isbn));
 
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