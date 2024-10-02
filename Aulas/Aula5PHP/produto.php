<?php
class Produto {
    public $nome;
    public $descricao;
    public $valor;
    public $imagem;

    public function __construct($nome, $descricao, $valor, $imagem) {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->valor = (float) $valor;
        $this->imagem = $imagem;
    }
    public function exibirInformacoes() {
        echo "
        <div class='card' style='width: 100%;'>
            <img src='{$this->imagem}' class='card-img-top' alt='Imagem do produto' style='height: 200px; object-fit: cover;'>
            <div class='card-body'>
                <h5 class='card-title'>{$this->nome}</h5>
                <p class='card-text'>{$this->descricao}</p>
                <p class='card-text'><strong>R$ " . number_format($this->valor, 2, ',', '.') . "</strong></p>
            </div>
        </div>";
    }
}
?>
