<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: inscricao.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Conectar ao banco de dados
$mysqli = new mysqli("localhost", "root", "", "caneta_de_ouro");
if ($mysqli->connect_errno) {
    echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}

// Recuperar os dados do usuário
$query = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

// Recuperar o nome de usuário
$username = $usuario['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale: 1.0">
    <link rel="stylesheet" href="landing.css">
    <title>Bem-vindo - Caneta de Ouro</title>
</head>
<body>
    <header>
        <h1>Bem-vindo, <?php echo htmlspecialchars($username); ?>!</h1>
        <button id="sair" onclick="sair()">Sair</button>
    </header>

    <main>
        <section>
            <h2>Criar Nova Composição</h2>
            <button onclick="window.location.href='composicao.html'">Criar Nova Composição</button>
        </section>

        <section>
            <h2>Minhas Composições</h2>
            <button onclick="window.location.href='minhas_composicoes.php'">Ver Minhas Composições</button>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Caneta de Ouro. Todos os direitos reservados.</p>
    </footer>

    <script>
        function sair() {
            window.location.href = 'logout.php'; // Redireciona para o arquivo de logout
        }
    </script>
</body>
</html>
