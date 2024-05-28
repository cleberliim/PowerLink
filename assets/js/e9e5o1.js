// Desabilitar o menu de contexto do botão direito do mouse
window.addEventListener('contextmenu', function (e) {
    e.preventDefault();
});

// Impedir a exibição do atalho de teclado para inspecionar (geralmente Ctrl+Shift+I ou F12)
window.addEventListener('keydown', function (e) {
    if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i')) {
        e.preventDefault();
    }
});