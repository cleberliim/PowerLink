<?php
require_once __DIR__ . '/../config/session_check.php';
?>

 
<div class="flex relative flex-col w-screen h-screen">
    <div id="preloader" class="absolute w-full h-full flex justify-center itens-center bg-zinc-50">
        <div class="teste"> </div>
        <div id="countdown" style="display: none;"></div>
    </div>


    <div class="w-full">
        <iframe id=" iframeContainer" class="overflow-auto" width="100%" height="1000px" src="https://app.powerbi.com/view?r=eyJrIjoiMTQ0MjIyODItNjg5YS00MzBhLThiMzQtYTU4ZGNhOTU2MjEyIiwidCI6IjE0NmMwOWZmLTg1MGEtNDA5OS04ZGUxLWJlMGIxNDNjYjRlOCJ9" frameborder="0" allowFullScreen="true"></iframe>

    </div>

    </main>
    <?php include_once('../includes/footer.php'); ?>