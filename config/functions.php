<?php
function autenticar_usuario($conn, $email, $senha) {
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            session_regenerate_id(); // Adicionado para evitar problemas de fixação de sessão
            $_SESSION['id_usuario'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['admin'] = $user['admin'];
            error_log("Usuário autenticado com sucesso: $email");
            return true;
        } else {
            error_log("Senha inválida para o usuário: $email");
        }
    } else {
        error_log("Usuário não encontrado: $email");
    }
    return false;
}

function get_bi_para_usuario($conn, $id_usuario) {
    $sql = "
        SELECT bi.* 
        FROM bi 
        JOIN usuario_bi ON bi.id_menu = usuario_bi.id_bi 
        WHERE usuario_bi.id_usuario = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        error_log("Erro na execução da consulta: " . htmlspecialchars($stmt->error));
        return false;
    }
    return $result;
}
?>
