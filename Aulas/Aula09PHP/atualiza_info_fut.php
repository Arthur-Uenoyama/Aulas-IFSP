<?php
    $servidor = 'localhost';
    $banco = 'futebol';
    $usuario = 'root';
    $senha = '';
    $id = $_GET['id'];
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

    $comandoSQL = "SELECT `nome`,`pontos` FROM `times` WHERE `id` = $id";   
    // echo $comandoSQL
 
    $comando = $conexao->prepare($comandoSQL);
    $resultado = $comando->execute();

    if($resultado){
        while($linha = $comando->fetch()){
?>
    <form action="recebe_atualizar.php" method="GET">
        <input type="hidden" name="id" value="<?php echo $id; ?>"> 
        <label for="nome">Nome:</label>
        <?php echo "<input type='text' name='nome' value='{$linha['nome']}'><br>"; ?>
        <label for="pontos">Pontos:</label>
        <?php echo "<input type='text' name='pontos' value='{$linha['pontos']}'><br>"; ?>
        <input type="submit">
    </form>

<?php        
        } 
    } else {
        echo "Erro no comando SQL";
    }

?>