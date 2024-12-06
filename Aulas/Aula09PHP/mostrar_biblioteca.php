<?php
$servidor = 'localhost';
$banco = 'livros';
$usuario = 'root';
$senha = '';

$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

$comandoSQL = 'SELECT * FROM `livros`';   

$comando = $conexao->prepare($comandoSQL);
$resultado = $comando->execute();

if ($resultado) {
    echo "Mostrando os produtos:<br>";
    while ($linha = $comando->fetch()) {
        echo $linha['titulo'] . ", " . $linha['idioma'] . ", " . $linha['editora'] . ", " . $linha['paginas'] . ", " . $linha['publicacao'] . ", " . $linha['isbn'] . "<br>";
        $id = $linha['id'];
        echo "<a href='apagar_biblioteca.php?id=$id'>Apagar</a><br>";
        echo "<a href='atualizar_info_livro.php?id=$id'>Editar</a><br>";
    } 
} else {
    echo "Erro no comando SQL";
}
?>
