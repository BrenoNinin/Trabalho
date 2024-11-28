<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: login.html");
    exit; // Sempre chame exit após redirecionar
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="comeco.css"> <!-- Adapte o caminho para o seu CSS -->
    <title>Bem-vindo - Caneta de Ouro</title>
</head>
<body>
    <header>
        <h1>Bem-vindo ao Caneta de Ouro!</h1>
    </header>

    <main>
        <p>Conteúdo exclusivo para usuários logados. Aqui você pode acessar suas composições, interagir e muito mais!</p>
        <a href="logout.php">Sair</a> <!-- Link para a página de logout -->
    </main>

    <footer>
        <p>&copy; 2024 Caneta de Ouro. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
