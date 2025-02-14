<?php
session_start();
require_once __DIR__ . '/config/conn.php';
require_once __DIR__ . '/config/functions.php';

// Verifica se o usuário é administrador
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: login.php");
    exit();
}

// Processa a adição ou remoção de acessos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $usuario_id = $_POST['usuario_id'];
    $action = $_POST['action'];

    // Adiciona acesso
    if ($action == 'add' && isset($_POST['bi_nome'], $_POST['link_bi'])) {
        $bi_nome = $_POST['bi_nome'];
        $link_bi = $_POST['link_bi'];

        // Insere um novo BI
        $sql_bi = "INSERT INTO bi (nome, link_bi) VALUES (?, ?)";
        $stmt_bi = $conn->prepare($sql_bi);
        $stmt_bi->bind_param("ss", $bi_nome, $link_bi);
        $stmt_bi->execute();
        $bi_id = $stmt_bi->insert_id;

        // Associa o novo BI ao usuário
        $sql_usuario_bi = "INSERT INTO usuario_bi (id_usuario, id_bi, link_bi) VALUES (?, ?, ?)";
        $stmt_usuario_bi = $conn->prepare($sql_usuario_bi);
        $stmt_usuario_bi->bind_param("iis", $usuario_id, $bi_id, $link_bi);
        $stmt_usuario_bi->execute();
    }

    // Remove acesso
    else if ($action == 'remove' && isset($_POST['bi_id'])) {
        $bi_id = $_POST['bi_id'];

        // Remove a associação do BI ao usuário
        $sql = "DELETE FROM usuario_bi WHERE id_usuario = ? AND id_bi = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $usuario_id, $bi_id);
        $stmt->execute();
    }
}

// Obtém usuários
$usuarios_result = $conn->query("SELECT * FROM usuarios");

// Obtém BIs associados ao usuário selecionado
$bi_associados = [];
if (isset($_POST['usuario_id']) && $_POST['usuario_id'] != '0') {
    $usuario_id = $_POST['usuario_id'];
    $bi_associados_result = $conn->query("SELECT bi.id_menu, bi.nome FROM bi JOIN usuario_bi ON bi.id_menu = usuario_bi.id_bi WHERE usuario_bi.id_usuario = $usuario_id");
    while ($bi_associado = $bi_associados_result->fetch_assoc()) {
        $bi_associados[] = $bi_associado;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body class="bg-gray-800 flex justify-center items-center min-h-screen">
    <div class="absolute top-0 left-0 p-4">
        <a href="./config/menus.php" class="text-white text-base">Voltar para Dashboard</a>
    </div>
    
    <div class="w-full max-w-4xl p-4">
        <div class="bg-white rounded-lg p-6 shadow-lg mb-8">
            <h1 class="text-3xl font-semibold text-center text-gray-900 mb-6">Administração de Acessos</h1>
            <form method="post" action="admin.php" class="space-y-6" id="adminForm">
                <div>
                    <label class="block text-gray-900">Usuário</label>
                    <select name="usuario_id" class="w-full p-3 rounded-lg text-black" onchange="this.form.submit()">
                        <option value="0">Selecione um usuário</option>
                        <?php while ($usuario = $usuarios_result->fetch_assoc()) : ?>
                            <option value="<?= $usuario['id'] ?>" <?= isset($usuario_id) && $usuario['id'] == $usuario_id ? 'selected' : '' ?>><?= $usuario['email'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="add-bi-form" id="add-bi-fields" style="display: <?= isset($usuario_id) && $usuario_id != '0' ? 'block' : 'none' ?>;">
                    <div>
                        <label class="block text-gray-900">Nome do BI</label>
                        <input type="text" name="bi_nome" class="w-full p-3 rounded-lg text-black" required>
                    </div>
                    <div class="mt-4">
                        <label class="block text-gray-900">Link do BI</label>
                        <input type="url" name="link_bi" class="w-full p-3 rounded-lg text-black" required>
                    </div>
                </div>

                <div class="remove-bi-form" id="remove-bi-fields" style="display: none;">
                    <div>
                        <label class="block text-gray-900">BI</label>
                        <select name="bi_id" class="w-full p-3 rounded-lg text-black">
                            <?php foreach ($bi_associados as $bi) : ?>
                                <option value="<?= $bi['id_menu'] ?>"><?= $bi['nome'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="flex justify-center space-x-6 mt-6">
                    <button type="submit" name="action" value="add" class="bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition">Adicionar Acesso</button>
                    <button type="button" onclick="toggleRemove()" class="bg-red-500 text-white p-3 rounded-lg hover:bg-red-600 transition">Remover Acesso</button>
                </div>
            </form>
        </div>

        <div class="table-container mt-6">
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                <table class="min-w-full table-auto text-gray-900">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">BI Nome</th>
                            <th class="px-4 py-2 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $usuarios_result->data_seek(0); // Resetando o ponteiro para os usuários
                        while ($usuario = $usuarios_result->fetch_assoc()) :
                            $usuario_id = $usuario['id'];
                            $stmt = $conn->prepare("
                        SELECT bi.id_menu, bi.nome, bi.link_bi 
                        FROM usuario_bi  
                        INNER JOIN bi ON usuario_bi.id_bi = bi.id_menu  
                        WHERE usuario_bi.id_usuario = ?
                    ");
                            $stmt->bind_param("i", $usuario_id);
                            $stmt->execute();
                            $acessos = $stmt->get_result();
                            while ($acesso = $acessos->fetch_assoc()) :
                        ?>
                                <tr class="border-b">
                                    <td class="px-4 py-2"><?= $usuario['email'] ?></td>
                                    <td class="px-4 py-2"><?= $acesso['nome'] ?></td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="<?= $acesso['link_bi'] ?>" target="_blank" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-external-link-alt"></i> Abrir
                                        </a>
                                        <form action="admin.php" method="POST" class="inline">
                                            <input type="hidden" name="usuario_id" value="<?= $usuario['id'] ?>">
                                            <input type="hidden" name="bi_id" value="<?= $acesso['id_menu'] ?>">
                                            <button type="submit" name="action" value="remove" class="text-red-500 hover:text-red-700 ml-4">
                                                <i class="fas fa-trash-alt"></i> Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                        <?php endwhile;
                        endwhile; ?>
                    </tbody>
                </table>

            </div>
        </div>


        <script>
            function toggleRemove() {
                document.getElementById('add-bi-fields').style.display = 'none';
                document.getElementById('remove-bi-fields').style.display = 'block';
            }
        </script>
</body>

</html>