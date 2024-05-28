<?php
session_start();
$_SESSION['id_usuario'] = 1;
header("Location: /portallog/config/test_menus.php");
exit();
?>
