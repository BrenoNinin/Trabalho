<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Conectar ao banco de dados
$mysqli = new mysqli("localhost", "root", "", "caneta_de_ouro");
if ($mysqli->connect_errno) {
    echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}

// Recuperar as composições do usuário
$query = "SELECT * FROM composicoes WHERE usuario_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale: 1.0">
    <link rel="stylesheet" href="composicoes.css">
    <title>Minhas Composições</title>
</head>
<body>
    <header>
        <div id="title">
            <h1>Minhas Composições</h1>
        </div>
    </header>

    <main>
        <section>
            <!-- Alterei o link para comeco.php -->
            <a href="comeco.php" class="voltar-btn">Voltar para a página inicial</a>
            <?php if ($resultado->num_rows > 0): ?>
                <?php while ($composicao = $resultado->fetch_assoc()): ?>
                    <div class="composicao-item">
                        <h3><?php echo htmlspecialchars($composicao['titulo']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($composicao['texto'])); ?></p>
                        <p class="data"><?php echo date('d/m/Y', strtotime($composicao['data'])); ?></p>
                        <a href="editar_composicao.php?id=<?php echo $composicao['id']; ?>" class="editar-btn">Editar</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Você ainda não criou nenhuma composição. Clique no botão abaixo para começar!</p>
                <a href="composicao.html" class="criar-btn">Criar Nova Composição</a>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
