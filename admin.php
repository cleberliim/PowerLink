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

    if ($action == 'add') {
        $bi_nome = $_POST['bi_nome'];
        $link_bi = $_POST['link_bi'];

        // Insere um novo BI
        $sql_bi = "INSERT INTO bi (nome_menu, link_bi) VALUES (?, ?)";
        $stmt_bi = $conn->prepare($sql_bi);
        $stmt_bi->bind_param("ss", $bi_nome, $link_bi);
        $stmt_bi->execute();
        $bi_id = $stmt_bi->insert_id;

        // Associa o novo BI ao usuário
        $sql_usuario_bi = "INSERT INTO usuario_bi (id_usuario, id_bi, iframe_link) VALUES (?, ?, ?)";
        $stmt_usuario_bi = $conn->prepare($sql_usuario_bi);
        $stmt_usuario_bi->bind_param("iis", $usuario_id, $bi_id, $link_bi);
        $stmt_usuario_bi->execute();
    } else if ($action == 'remove') {
        if (isset($_POST['bi_id'])) {
            $bi_id = $_POST['bi_id'];

            // Remove a associação do BI ao usuário
            $sql = "DELETE FROM usuario_bi WHERE id_usuario = ? AND id_bi = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $usuario_id, $bi_id);
            $stmt->execute();
        }
    }
}

// Obtém usuários
$usuarios = $conn->query("SELECT * FROM usuarios");

// Obtém BIs associados ao usuário selecionado, se um usuário for selecionado
$bi_associados = [];
if (isset($_POST['usuario_id']) && $_POST['usuario_id'] != '0') {
    $usuario_id = $_POST['usuario_id'];
    $bi_associados_result = $conn->query("SELECT bi.id_menu, bi.nome_menu FROM bi JOIN usuario_bi ON bi.id_menu = usuario_bi.id_bi WHERE usuario_bi.id_usuario = $usuario_id");
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
    <style>
        .bg-comando {
            background: linear-gradient(to bottom, #111525, #161C31) !important;
        }
    </style>
</head>

<body class="bg-slate-200">
    <div class="h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h1 class="text-3xl font-bold mb-6 text-center text-slate-400">Administração de Acessos</h1>
            <form method="post" action="admin.php" class="mb-6" id="adminForm">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Usuário</label>
                    <select name="usuario_id" class="w-full border-2 py-2 px-3 rounded-2xl" onchange="this.form.submit()">
                        <option value="0">Selecione um usuário</option>
                        <?php while ($usuario = $usuarios->fetch_assoc()) : ?>
                            <option value="<?= $usuario['id'] ?>" <?= isset($usuario_id) && $usuario['id'] == $usuario_id ? 'selected' : '' ?>><?= $usuario['email'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4" id="add-bi-fields">
                    <label class="block text-gray-700 mb-2">Nome do BI</label>
                    <input type="text" name="bi_nome" class="w-full border-2 py-2 px-3 rounded-2xl" required>
                    <label class="block text-gray-700 mb-2 mt-4">Link do BI</label>
                    <input type="url" name="link_bi" class="w-full border-2 py-2 px-3 rounded-2xl" required>
                </div>
                <div class="mb-4" id="remove-bi-fields" style="display: none;">
                    <label class="block text-gray-700 mb-2">BI</label>
                    <select name="bi_id" class="w-full border-2 py-2 px-3 rounded-2xl">
                        <?php foreach ($bi_associados as $bi) : ?>
                            <option value="<?= $bi['id_menu'] ?>"><?= $bi['nome_menu'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex space-x-4 justify-center">
                    <button type="submit" name="action" value="add" class="bg-comando text-white py-2 px-4 rounded-2xl">Adicionar Acesso</button>
                    <button type="button" onclick="toggleRemove()" class="bg-red-500 text-white py-2 px-4 rounded-2xl">Remover Acesso</button>
                </div>
            </form>
            <h2 class="text-2xl font-bold mb-4 text-center text-slate-400">Acessos por Usuário</h2>
            <?php
            $usuarios->data_seek(0); // Reset the result set pointer
            while ($usuario = $usuarios->fetch_assoc()) :
                $usuario_id = $usuario['id'];
                $acessos = $conn->query("SELECT bi.id_menu, bi.nome_menu, usuario_bi.iframe_link FROM usuario_bi JOIN bi ON usuario_bi.id_bi = bi.id_menu WHERE usuario_bi.id_usuario = $usuario_id");
            ?>
                <div class="mb-4">
                    <h3 class="text-xl font-semibold text-gray-700"><?= $usuario['email'] ?></h3>
                    <ul class="list-disc list-inside">
                        <?php while ($acesso = $acessos->fetch_assoc()) : ?>
                            <li class="text-gray-600">
                                <?= $acesso['nome_menu'] ?> - <a href="<?= $acesso['iframe_link'] ?>" target="_blank" class="text-blue-500 hover:underline">Abrir BI</a>
                                <form method="post" action="admin.php" style="display:inline;">
                                    <input type="hidden" name="usuario_id" value="<?= $usuario_id ?>">
                                    <input type="hidden" name="bi_id" value="<?= $acesso['id_menu'] ?>">
                                    <input type="hidden" name="action" value="remove">
                                    <button type="submit" class="text-red-500 hover:underline ml-2">X</button>
                                </form>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function toggleRemove() {
            document.getElementById('add-bi-fields').style.display = 'none';
            document.getElementById('remove-bi-fields').style.display = 'block';
            document.querySelector('[name="bi_nome"]').disabled = true;
            document.querySelector('[name="link_bi"]').disabled = true;
            document.querySelector('[name="bi_id"]').disabled = false;
            const removeButton = document.querySelector('button[onclick="toggleRemove()"]');
            removeButton.type = 'submit';
            removeButton.name = 'action';
            removeButton.value = 'remove';
        }

        document.getElementById('adminForm').addEventListener('submit', function(event) {
            if (document.getElementById('remove-bi-fields').style.display !== 'block') {
                document.querySelector('[name="bi_nome"]').disabled = false;
                document.querySelector('[name="link_bi"]').disabled = false;
                document.querySelector('[name="bi_id"]').disabled = true;
            }
        });
    </script>
</body>

</html>