<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Conectar ao banco de dados (substitua com suas próprias configurações)
include_once('../config/conn.php');

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Receber dados do formulário
$name = $_POST['usuario'];
$email = $_POST['email'];
$password = $_POST['senha']; // Lembre-se de criptografar a senha antes de armazená-la

// Processar upload de imagem
if ($_FILES['foto']['name']) {
    $foto_name = "user.png"; // Nome fixo para a imagem
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_path = '../assets/images/' . $foto_name;
    move_uploaded_file($foto_tmp, $foto_path);

    // Atualizar o caminho da foto no banco de dados
    $sql_update_photo = "UPDATE usuarios SET foto='$foto_path' WHERE id='$user_id'";
    if ($conn->query($sql_update_photo) !== TRUE) {
        echo 'Erro ao atualizar a foto.' . $conn->error;
    }
}

// Atualizar os dados do usuário
$sql = "UPDATE usuarios SET usuarios='$name', email='$email', senha='$password' WHERE id='$user_id'"; // Substitua 'usuarios' e 'id' de acordo com sua estrutura

if ($conn->query($sql) === TRUE) {
    header("Location: profile.php");
} else {
    echo 'Erro ao atualizar.' . $conn->error;
}

$conn->close();
