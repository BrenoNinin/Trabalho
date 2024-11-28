<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: inscricao.html");
    exit;
}

// Conectar ao banco de dados
include('conexao.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];
    $diretorio = 'uploads/';  // Pasta onde as fotos serão armazenadas
    $nomeArquivo = basename($foto['name']);
    $caminhoArquivo = $diretorio . $nomeArquivo;
    $uploadOk = 1;
    $tipoArquivo = strtolower(pathinfo($caminhoArquivo, PATHINFO_EXTENSION));

    // Verifique se o arquivo é uma imagem real
    if (getimagesize($foto['tmp_name']) === false) {
        echo "O arquivo não é uma imagem.";
        $uploadOk = 0;
    }

    // Verifique se o arquivo já existe
    if (file_exists($caminhoArquivo)) {
        echo "Desculpe, o arquivo já existe.";
        $uploadOk = 0;
    }

    // Limite de tamanho do arquivo (5MB)
    if ($foto['size'] > 5000000) {
        echo "Desculpe, o arquivo é muito grande.";
        $uploadOk = 0;
    }

    // Permitir apenas certos formatos de imagem
    if ($tipoArquivo != "jpg" && $tipoArquivo != "jpeg" && $tipoArquivo != "png" && $tipoArquivo != "gif") {
        echo "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
        $uploadOk = 0;
    }

    // Verifique se $uploadOk está definido como 0 devido a um erro
    if ($uploadOk == 0) {
        echo "Desculpe, seu arquivo não foi enviado.";
    } else {
        // Caso contrário, tente fazer o upload do arquivo
        if (move_uploaded_file($foto['tmp_name'], $caminhoArquivo)) {
            echo "O arquivo " . htmlspecialchars($nomeArquivo) . " foi enviado com sucesso.";

            // Atualizar o banco de dados com o caminho da imagem
            $caminhoImagem = $caminhoArquivo; // Salve o caminho da imagem no banco de dados
            $query = "UPDATE usuarios SET foto = ? WHERE id = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("si", $caminhoImagem, $_SESSION['usuario_id']);
            $stmt->execute();

            // Redireciona para comeco.php após o upload bem-sucedido
            header("Location: comeco.php");
            exit;
        } else {
            echo "Desculpe, houve um erro ao enviar o arquivo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Perfil - Caneta de Ouro</title>
</head>
<body>
    <h1>Atualizar Perfil</h1>

    <!-- Formulário para upload de foto -->
    <form action="perfil.php" method="POST" enctype="multipart/form-data">
        <label for="foto">Foto de Perfil:</label>
        <input type="file" name="foto" id="foto" accept="image/*">
        <button type="submit">Atualizar Foto</button>
    </form>

    <h2>Foto Atual:</h2>
    <?php
    // Mostrar a foto atual do usuário
    $query = "SELECT foto FROM usuarios WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $_SESSION['usuario_id']);
    $stmt->execute();
    $stmt->bind_result($foto);
    $stmt->fetch();

    if ($foto) {
        echo "<img src='" . $foto . "' alt='Foto de perfil' />";
    } else {
        echo "<img src='uploads/default-avatar.png' alt='Foto de perfil' />";  // Imagem padrão caso o usuário não tenha foto
    }
    ?>

    <br>
    <a href="comeco.php">Voltar</a>
</body>
</html>
