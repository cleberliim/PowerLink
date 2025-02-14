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
        session_start(); // Garante que a sessão esteja ativa

        // Definir sessão de usuário autenticado
        $_SESSION['usuario'] = $email;
        $_SESSION['admin'] = true; // Ou verificar no banco se o usuário é admin antes de definir como true

        header("Location: config/menus.php");
        exit();
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
    <title>Login</title>
</head>

<body>
    <div class="h-screen flex flex-col md:flex-row">
        <div class="w-full md:w-1/2 flex justify-center items-center bg-zinc-950 p-4">
            <p class="text-3xl text-slate-400 flex items-center gap-4">
                PowerLink
                <img class="h-6 w-auto" src="assets/images/logo-header.png" alt="Logo">
            </p>
        </div>
        <div class="w-full md:w-1/2 flex justify-center items-center bg-white pt-40 md:pt-0">

            <form autocomplete="off" class="bg-white w-full max-w-sm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <h1 class="text-zinc-950 font-bold text-3xl mb-10 text-center">Login</h1>
                <div class="flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                    <input class="w-full pl-2 outline-none border-none" type="text" name="email" required placeholder="Email" />
                </div>
                <div class="flex items-center border-2 py-2 px-3 rounded-2xl">
                    <input class="w-full pl-2 outline-none border-none" type="password" name="senha" required placeholder="Password" />
                </div>
                <button type="submit" class="block w-full bg-zinc-950 hover:bg-zinc-800 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">
                    Entrar
                </button>
                <div class="text-center mt-4">
                    <a href="createaccount.php" class="text-zinc-950 hover:underline">Solicitar Acesso</a>
                </div>
                <?php if ($erro) { ?>
                    <p class="text-red-600 text-center mt-2">Falha na autenticação. Verifique email e senha.</p>
                <?php } ?>
                <div class="text-blue-600 text-center mt-4">
                    <?php echo $debug_message; ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>