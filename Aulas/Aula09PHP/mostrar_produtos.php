<?php
$servidor = 'localhost';
$banco = 'loja';
$usuario = 'root';
$senha = '';

$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

$comandoSQL = 'SELECT * FROM `produtos`';   

$comando = $conexao->prepare($comandoSQL);
$resultado = $comando->execute();

if ($resultado) {
    echo "Mostrando os produtos:<br>";
    while ($linha = $comando->fetch()) {
        echo $linha['nome'] . ", " . $linha['url'] . ", " . $linha['descricao'] . ", " . $linha['precos'] . "<br>";
        $id = $linha['id'];
        echo "<a href='apagar_produtos.php?id=$id'>Apagar</a><br>";
        echo "<a href='atualizar_info_produto.php?id=$id'>Editar</a><br>";
    } 
} else {
    echo "Erro no comando SQL";
}
?>
