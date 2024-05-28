<?php
require_once __DIR__ . '/../config/session_check.php';
require_once __DIR__ . '/../config/conn.php';

// Verifica se o ID do usuário está definido na sessão
if (!isset($_SESSION['user_id'])) {
    echo "ID de usuário não definido na sessão.";
    exit;
}

$user_id = $_SESSION['user_id']; // Supondo que o ID do usuário está armazenado na sessão

$sql = "SELECT iframe_link FROM usuario_bi WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);

// Verifica se a preparação da declaração foi bem-sucedida
if (!$stmt) {
    echo "Erro na preparação da consulta: " . $conn->error;
    exit;
}

$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($iframe_link);
$stmt->fetch();
$stmt->close();
$conn->close();

if (!$iframe_link) {
    echo "Nenhum iframe associado a este usuário.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>B.I. Frame</title>
</head>

<body>
    <iframe src="<?php echo htmlspecialchars($iframe_link); ?>" class="w-full h-full border-none" style="overflow: hidden;"></iframe>
</body>

</html>
