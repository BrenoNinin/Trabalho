<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.html");
    exit();
}

if (isset($_GET['id'])) {
    $composicao_id = $_GET['id'];
    $usuario_id = $_SESSION['usuario_id'];

    // Conectar ao banco de dados
    $mysqli = new mysqli("localhost", "root", "", "caneta_de_ouro");

    if ($mysqli->connect_errno) {
        echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        exit();
    }

    // Recuperar a composição do banco
    $query = "SELECT * FROM composicoes WHERE id = ? AND usuario_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $composicao_id, $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $composicao = $resultado->fetch_assoc();
    } else {
        echo "Composição não encontrada.";
        exit();
    }

    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="composicao.css">
    <title>Editar Composição</title>
</head>
<body>

<header>
    <h1>Editar Composição</h1>
</header>

<main>
    <section>
        <form action="atualizar_composicao.php" method="POST">
            <input type="hidden" name="id" value="<?= $composicao['id'] ?>">

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?= $composicao['titulo'] ?>" required><br><br>

            <h2>Escreva sua composição:</h2>
            <textarea id="composicao" name="composicao" rows="20" cols="80" required><?= $composicao['texto'] ?></textarea><br><br>

            <button type="submit">Salvar Alterações</button>
        </form>
        
        <a href="comeco.php" class="voltar-btn">Voltar para a Página Inicial</a>
    </section>
</main>

</body>
</html>
