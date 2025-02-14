<?php
session_start();
require_once __DIR__ . '/config/conn.php';
require_once __DIR__ . '/config/functions.php';

$erro = false;
$debug_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $debug_message .= "Tentativa de login com email: $email<br>";

    if (autenticar_usuario($conn, $email, $senha)) {
        $debug_message .= "Autenticação bem-sucedida para o email: $email<br>";
        $debug_message .= "Redirecionando para /portallog/config/menus.php após autenticação bem-sucedida<br>";
        error_log("Autenticação bem-sucedida para o email: $email. Redirecionando...");
        echo $debug_message; // Mensagem de depuração
        header("Location: config/menus.php");
        exit();
    } else {
        $erro = true;
        $debug_message .= "Falha na autenticação do usuário: $email<br>";
        error_log("Falha na autenticação do usuário: $email");
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
    <title>Login</title>
</head>

<body class="bg-slate-200">
    <div class="h-screen flex">
        <div class="flex w-full justify-around items-center relative bg-zinc-950">
            <div class="w-full flex justify-center items-center">
                <p class="text-3xl text-slate-400 flex items-center gap-4">
                    PowerLink
                    <img class="h-6 w-auto" src="assets/images/logo-header.png" alt="Logo">
                </p>
            </div>
        </div>
        <div class="flex w-1/2 justify-center items-center bg-white">
            <form autocomplete="off" class="bg-white w-96" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <h1 class="text-zinc-950 font-bold text-3xl mb-10">Login</h1>
                <div class="flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                    <input class="w-full pl-2 outline-none border-none" type="text" name="email" required placeholder="Email" />
                </div>
                <div class="flex items-center border-2 py-2 px-3 rounded-2xl">
                    <input class="w-full pl-2 outline-none border-none" type="password" name="senha" required placeholder="Password" />
                </div>
                <button type="submit" class="block w-full bg-zinc-950 mt-4 py-2 rounded-2xl text-white font-semibold mb-2 mt-8">Entrar</button>
                <div class="text-center mt-4">
                    <a href="createaccount.php" class="text-zinc-950 hover:underline">Solicitar Acesso</a>
                </div>
                <?php if ($erro) { ?>
                    <p style="color: red;">Falha na autenticação. Verifique email e senha.</p>
                <?php } ?>
                <div style="margin-top: 20px; color: blue;">
                    <?php echo $debug_message; ?>
                </div>
            </form>
        </div>
    </div>

</body>

</html>