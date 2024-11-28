const botaoEntrar = document.getElementById('entrar');
const darkModeButton = document.getElementById('darkModeToggle');

// Animação do botão "ENTRAR"
botaoEntrar.addEventListener('click', function() {
    botaoEntrar.classList.add('clicado');

    // Remove a classe após a animação para permitir um novo clique
    setTimeout(function() {
        botaoEntrar.classList.remove('clicado');
    }, 500); // Tempo da animação (0.5s)
});

// Alternar entre modo claro e escuro
darkModeButton.addEventListener('click', function() {
    document.body.classList.toggle('dark-mode'); // Alterna a classe 'dark-mode' no body
});