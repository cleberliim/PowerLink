<?php
require_once __DIR__ . '/../config/session_check.php';
include_once('../includes/header.php');
include_once('../config/conn.php');
?>

<div class="w-full flex justify-center items-center">
    <div class=" rounded-lg  w-96 ">
        <form class="mt-6" action="updateprofile.php" method="post" enctype="multipart/form-data">
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 rounded-full overflow-hidden mb-5">
                    <img src="../assets/images/user.png" class="w-full h-full object-cover">
                </div>
            </div>
            <input type="text" class="mt-3 w-full p-2 border rounded-lg focus:ring focus:ring-blue-200 " name="usuario" placeholder="Seu nome de usuário" required>

            <input type="text" class="mt-3 w-full p-2 border rounded-lg focus:ring focus:ring-blue-200" name="email" placeholder="Seu e-mail" required>

            <input type="password" class="mt-3 w-full p-2 border rounded-lg focus:ring focus:ring-blue-200" name="senha" placeholder="Sua senha" required value="<?php ?>">


            <div class="flex flex-col items-center">

                <input type="file" class="mt-3 relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-xs font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary" name="foto">
            </div>

            <button id="sucessalert" type="submit" class="mt-6 w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">Atualizar</button>

            <script>
                document.getElementById("sucessalert").addEventListener("click", function() {
                    // Coloque o código JavaScript do Toastr aqui
                    toastr.success("Cadastro atualizado com sucesso!");
                });
            </script>
        </form>
    </div>
</div> 

<?php include_once('../includes/footer.php') ?>