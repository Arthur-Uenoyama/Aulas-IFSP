<?php
    $servidor = 'localhost';
    $banco = 'futebol';
    $usuario = 'root';
    $senha = '';
    
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

    $comandoSQL = 'SELECT * FROM `times`';   

    $comando = $conexao->prepare($comandoSQL);
    $resultado = $comando->execute();

    if($resultado){
        echo "Mostrando os times";
        while($linha = $comando->fetch()){
            echo "<br>";
            echo $linha['nome'] . $linha['pontos'];
            $id = $linha['id'];
            echo "<a href='apaga_futebol.php?id=$id'>Apagar</a><br>";
        } 
    } else {
        echo "Erro no comando SQL";
    }

?>