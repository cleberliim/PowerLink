<?php
require_once __DIR__ . '/conn.php';

// Verifica se os campos foram enviados via POST
if (!isset($_POST['usuario_id']) || !isset($_POST['bi_id']) || !isset($_POST['iframe_link'])) {
    die("Erro: Todos os campos são obrigatórios.");
}

$usuario_id = intval($_POST['usuario_id']);
$bi_id = intval($_POST['bi_id']);
$iframe_link = trim($_POST['iframe_link']);

// Verifique se todos os campos foram preenchidos corretamente
if ($usuario_id == 0 || $bi_id == 0 || empty($iframe_link)) {
    die("Erro: Todos os campos são obrigatórios.");
}

$sql = "INSERT INTO usuario_bi (id_usuario, id_bi, iframe_link) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Verifica se a preparação da declaração foi bem-sucedida
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("iis", $usuario_id, $bi_id, $iframe_link);

if ($stmt->execute()) {
    echo "Associação salva com sucesso.";
} else {
    echo "Erro ao salvar a associação: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
