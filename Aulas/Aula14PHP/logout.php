<?php
session_start();
session_unset();
session_destroy();
header('Location: cadastro_usuario.php');
exit();
?>
