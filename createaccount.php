<?php
require_once __DIR__ . '/config/conn.php';
require_once __DIR__ . '/config/functions.php';

$erro = false;
$sucesso = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    // Lógica para salvar o novo usuário no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {
        $sucesso = true;
    } else {
        $erro = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <style>

    </style>
    <title>Criar</title>
</head>

<body class="bg-zinc-950">
    <div class="h-screen flex items-center justify-center">
        <div class="absolute top-0 left-0 p-4">
            <a href="login.php" class="text-slate-400 hover:underline">Voltar ao login</a>
        </div>


        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h1 class="text-3xl font-bold mb-6 text-center text-slate-400 pb-10">Criar conta</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Nome Completo</label>
                    <input class="w-full border-2 py-2 px-3 rounded-2xl" type="text" name="nome" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input class="w-full border-2 py-2 px-3 rounded-2xl" type="email" name="email" required />
                </div>
                <div class="mb-10">
                    <label class="block text-gray-700 mb-2">Senha</label>
                    <input class="w-full border-2 py-2 px-3 rounded-2xl" type="password" name="senha" required />
                </div>
                <button type="submit" class="block w-full bg-zinc-950 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">Criar Conta</button>
                <?php if ($erro) { ?>
                    <script>
                        toastr.error("Erro ao criar a conta. Tente novamente.");
                    </script>
                <?php } elseif ($sucesso) { ?>
                    <script>
                        toastr.success("Conta criada com sucesso. Você pode fazer login agora.");
                    </script>
                <?php } ?>
            </form>
        </div>
    </div>
</body>

</html>