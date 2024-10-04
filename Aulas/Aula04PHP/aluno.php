<?php
class Aluno {
    public $nome;
    public $nascimento;
    public $matricula;
    public $curso;

    public function __construct($nome, $nascimento, $matricula, $curso) {
        $this->nome = $nome;
        $this->nascimento = $nascimento;
        $this->matricula = $matricula;
        $this->curso = $curso;
    }

    public function idade() {
        $dataNascimento = new DateTime($this->nascimento);
        $hoje = new DateTime();
        $idade = $hoje->diff($dataNascimento)->y;
        return $idade;
    }
}
?>
