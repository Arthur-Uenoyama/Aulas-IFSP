<?php
    $servidor = 'localhost';
    $banco = 'livros';
    $usuario = 'root';
    $senha = '';
    $id = $_GET['id'];
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

    $comandoSQL = "SELECT `titulo`,`editora`, `paginas`,`idioma` FROM `livros` WHERE `id` = $id";   
    // echo $comandoSQL
 
    $comando = $conexao->prepare($comandoSQL);
    $resultado = $comando->execute();

    if($resultado){
        while($linha = $comando->fetch()){
?>
    <form action="recebe_atualizar_livro.php" method="GET">
        <input type="hidden" name="id" value="<?php echo $id; ?>"> 
        <label for="url">titulo:</label>
        <?php echo "<input type='text' name='titulo' value='{$linha['titulo']}'><br>"; ?>
        <label for="descricao">editora:</label>
        <?php echo "<input type='text' name='editora' value='{$linha['editora']}'><br>"; ?>
        <label for="pontos">paginas:</label>
        <?php echo "<input type='text' name='paginas' value='{$linha['paginas']}'><br>"; ?>
        <label for="pontos">idioma:</label>
        <?php echo "<input type='text' name='idioma' value='{$linha['idioma']}'><br>"; ?>
        <input type="submit">
    </form>

<?php        
        } 
    } else {
        echo "Erro no comando SQL";
    }

?>