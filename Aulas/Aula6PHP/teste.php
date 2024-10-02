<?php
try {
    $numero1 = 10;
    $numero2 = 0;
    $resultado = $numero1 / $numero2;
    echo "O resultado da divisão é: " . $resultado;
} catch (Error $excecao) {
    echo "Erro: " . $excecao->getMessage();
} catch (DivisionByZeroError $divisaoErrada) {
    echo "Erro na divisão: " . $divisaoErrada->getMessage();
}
?>

