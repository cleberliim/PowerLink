<?php

require_once __DIR__ . '/../config/session_check.php';
require_once __DIR__ . '/../config/conn.php';
require_once __DIR__ . '/../config/functions.php';


$id_usuario = $_SESSION['id_usuario'];
$bi_menus = get_bi_para_usuario($conn, $id_usuario);

?>

<?php require_once __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>

 