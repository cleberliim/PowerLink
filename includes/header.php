<?php
require_once __DIR__ . '/../config/session_check.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwindcss-->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- Inclua o jQuery usando um CDN (necessário para o Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Inclua o JavaScript do Toastr usando um CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- css-->
    <link rel="stylesheet" href="../assets/css/custom.css" />

    <!--<script src="../js/e9e5o1.js"></script>  -->

    <title>Dashboard</title>
</head>

<body class="overflow-hidden text-sm">
    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />

    <!-- page -->
    <main class="min-h-screen w-full bg-gray-100 text-gray-700" x-data="layout">
        <!-- header page -->
        <header class="flex w-full items-center justify-between bg-comando p-2">
            <!-- logo -->
            <div class="flex items-center space-x-2 z-50">
                <button type="button" class="text-3xl" @click="toggleAside"><i class="bx bx-menu text-white pl-2"></i></button>
                <div><a href="../config/menus.php"><img class="block h-6 w-auto pl-6" src="../assets/images/integralogis.svg"></a></div>
            </div>

            <!-- button profile -->
            <div>
                <button type="button" @click="profileOpen = !profileOpen" @click.outside="profileOpen = false" class="w-10 h-10 overflow-hidden rounded-full">
                    <img src="../assets/images/user.png" alt="user" />
                </button>

                <!-- dropdown profile -->
                <div class="z-40 absolute right-2 mt-1 w-48 divide-y divide-gray-200 rounded-md border border-gray-200 bg-white shadow-md" x-show="profileOpen" x-transition>
                    <div class="flex items-center space-x-2 p-2">
                        <div class="font-medium">Cleber Lima</div>
                    </div>

                    <div class="flex flex-col space-y-3 p-2">
                        <a href="../pages/profile.php" class="transition hover:text-blue-600">Perfil</a>
                    </div>

                    <div class="p-2">
                        <button class="flex items-center space-x-2 transition hover:text-blue-600">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <form method="post" action="../sair.php">
                                <button type="submit" name="logout">
                                    Sair
                                </button>
                            </form>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex">
            <!-- aside -->
            <aside class="flex flex-col space-y-2 border-r-2 border-gray-200 bg-white p-2 transition-all duration-300" :class="{'w-72': asideOpen, 'w-0': !asideOpen}" style="height: 90.5vh" x-show="asideOpen">
                <?php
                if ($bi_menus->num_rows > 0) {
                    while ($bi = $bi_menus->fetch_assoc()) {
                        echo '<a href="#" @click.prevent="iframeSrc = \'' . $bi['link_bi'] . '\'" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">';
                        echo '<span><i class="fas fa-icon"></i></span>';
                        echo '<span class="pl-4 text-black">' . $bi['nome'] . '</span>'; // $bi['nome'] contém o nome do menu que está no banco na tabela bi
                        echo '</a>';
                    }
                } else {
                    echo '<p>Nenhum menu disponível.</p>';
                }
                ?>
            </aside>

            <!-- Main content -->
            <div class="flex-grow  h-screen	 bg-gray-100 transition-all duration-300" :class="{'w-full': !asideOpen, 'w-auto': asideOpen}">
                <iframe :src="iframeSrc" class="w-full h-full border-none transition-all duration-300" style="overflow: hidden;"></iframe>
            </div>
        </div>
    </main>