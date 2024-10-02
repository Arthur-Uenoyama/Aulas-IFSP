<?php
    class EntradaInvalidaException extends Exception {
        public function __construct($mensagem = "", $codigo = 0, Throwable $anterior = null) {
            parent::__construct($mensagem, $codigo, $anterior);
        }
    }
    function realizarOperacao($numero1, $numero2, $operacao) {
        switch ($operacao) {
            case 'adicao':
                return $numero1 + $numero2;
            case 'subtracao':
                return $numero1 - $numero2;
            case 'multiplicacao':
                return $numero1 * $numero2;
            case 'divisao':
                if ($numero2 == 0) {
                    throw new DivisionByZeroError("Não é possível dividir por zero.");
                }
                return $numero1 / $numero2;
            default:
                throw new Exception("Operação desconhecida.");
        }
    }
    $mensagem = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $numero1 = $_POST['numero1'];
            $numero2 = $_POST['numero2'];
            $operacao = $_POST['operacao'];

            if (!is_numeric($numero1) || !is_numeric($numero2)) {
                throw new EntradaInvalidaException("Devem ser apenas números.");
            }
            $numero1 = (float)$numero1;
            $numero2 = (float)$numero2;
            $resultado = realizarOperacao($numero1, $numero2, $operacao);
            $mensagem = '<div class="alert alert-success text-center">Resultado = ' . $resultado . '</div>';
        } catch (DivisionByZeroError $e) {
            $mensagem = '<div class="alert alert-danger text-center">Erro: ' . $e->getMessage() . '</div>';
        } catch (EntradaInvalidaException $e) {
            $mensagem = '<div class="alert alert-warning text-center">Erro de Entrada: ' . $e->getMessage() . '</div>';
        } catch (Exception $e) {
            $mensagem = '<div class="alert alert-danger text-center">Erro inesperado: ' . $e->getMessage() . '</div>';
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora PHP</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Calculadora</h2>
    <form method="POST" class="mt-4">
        <div class="form-group">
            <label for="numero1">X</label>
            <input type="text" class="form-control" name="numero1" id="numero1" placeholder="Digite o primeiro número">
        </div>
        <div class="form-group">
            <label for="numero2">Y</label>
            <input type="text" class="form-control" name="numero2" id="numero2" placeholder="Digite o segundo número">
        </div>
        <div class="form-group text-center">
            <button type="submit" name="operacao" value="adicao" class="btn btn-primary mx-1">Adição</button>
            <button type="submit" name="operacao" value="subtracao" class="btn btn-primary mx-1">Subtração</button>
            <button type="submit" name="operacao" value="multiplicacao" class="btn btn-primary mx-1">Multiplicação</button>
            <button type="submit" name="operacao" value="divisao" class="btn btn-primary mx-1">Divisão</button>
        </div>
        <?php if ($mensagem): ?>
            <div class="mt-3">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
