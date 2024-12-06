<?php
    $servidor = 'localhost';
    $banco = 'loja';
    $usuario = 'root';
    $senha = '';
    $id = $_GET['id'];
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

    $comandoSQL = "SELECT `nome`,`url`, `descricao`,`precos` FROM `produtos` WHERE `id` = $id";   
    // echo $comandoSQL
 
    $comando = $conexao->prepare($comandoSQL);
    $resultado = $comando->execute();

    if($resultado){
        while($linha = $comando->fetch()){
?>
    <form action="recebe_atualizar_prod.php" method="GET">
        <input type="hidden" name="id" value="<?php echo $id; ?>"> 
        <label for="nome">Nome:</label>
        <?php echo "<input type='text' name='nome' value='{$linha['nome']}'><br>"; ?>
        <label for="url">URL:</label>
        <?php echo "<input type='text' name='url' value='{$linha['url']}'><br>"; ?>
        <label for="descricao">descricao:</label>
        <?php echo "<input type='text' name='descricao' value='{$linha['descricao']}'><br>"; ?>
        <label for="pontos">precos:</label>
        <?php echo "<input type='text' name='precos' value='{$linha['precos']}'><br>"; ?>
        <input type="submit">
    </form>

<?php        
        } 
    } else {
        echo "Erro no comando SQL";
    }

?>