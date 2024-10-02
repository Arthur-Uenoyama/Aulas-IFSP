<?php
session_start();
require_once 'produto.php';
function produtoJaExiste($novoProduto, $produtos) {
    foreach ($produtos as $produto_serializado) {
        $produto = unserialize($produto_serializado);
        if ($produto instanceof Produto) {
            if ($produto->nome === $novoProduto->nome &&
                $produto->descricao === $novoProduto->descricao &&
                $produto->valor === $novoProduto->valor &&
                $produto->imagem === $novoProduto->imagem) {
                return true;
            }
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nome']) && !empty($_POST['descricao']) && !empty($_POST['valor']) && !empty($_POST['imagem'])) {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $valor = (float) $_POST['valor'];
        $imagem = $_POST['imagem'];
        $novoProduto = new Produto($nome, $descricao, $valor, $imagem);

        if (!isset($_SESSION['produtos'])) {
            $_SESSION['produtos'] = [];
        }
        if (!produtoJaExiste($novoProduto, $_SESSION['produtos'])) {
            $_SESSION['produtos'][] = serialize($novoProduto);
            echo "Produto adicionado com sucesso!";
        } else {
            echo "Produto já existe!";
        }

        header('Location: mostra.php');
        exit;
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    header('Location: novo.php');
    exit;
}
