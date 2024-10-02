<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['nome'] = $_POST['nome'];
    header('Location: mostrar_nome.php');
    exit();
} else {
    header('Location: primeira.php');
    exit();
}
?>
