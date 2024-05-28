<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    die("Sessão não iniciada.");
}
echo "Sessão iniciada com sucesso. ID do usuário: " . $_SESSION['id_usuario'];
?>
