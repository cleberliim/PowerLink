<script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>

 <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('layout', () => ({
            asideOpen: true,
            profileOpen: false,
            iframeSrc: '', // Inicializa o iframeSrc
            toggleAside() {
                this.asideOpen = !this.asideOpen;
                if (!this.asideOpen) {
                    document.querySelector('aside').style.width = '0';
                } else {
                    document.querySelector('aside').style.width = '18rem'; // 72 * 0.25rem (1rem = 16px)
                }
            }
        }));
    });
    </script>

<script>
    const countdownElement = document.getElementById('countdown');
    const iframeContainer = document.getElementById('iframeContainer');

    let countdown = 3;
    const countdownInterval = setInterval(() => {
        countdown--;
        countdownElement.textContent = countdown;
        if (countdown === 0) {
            clearInterval(countdownInterval);
            document.getElementById('preloader').style.display = 'none';
            iframeContainer.style.display = 'block';
            countdownElement.style.display = 'none'; // Oculta o contador
            countdownElement.style.color = '#F5F5F5'; // Muda a cor do contador para vermelho

        }
    }, 900);
</script>
</body>

</html>