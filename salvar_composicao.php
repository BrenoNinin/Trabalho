<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "Você precisa estar logado para salvar uma composição.";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Verificar se os campos foram enviados
if (isset($_POST['titulo']) && isset($_POST['texto'])) {
    $titulo = $_POST['titulo'];
    $texto = $_POST['texto'];

    // Verificar se os campos não estão vazios
    if (empty($titulo) || empty($texto)) {
        echo "Por favor, preencha todos os campos.";
        exit();
    }

    // Conectar ao banco de dados
    $mysqli = new mysqli("localhost", "root", "", "caneta_de_ouro");

    // Verificar se houve erro na conexão
    if ($mysqli->connect_errno) {
        echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        exit();
    }

    // Preparar a consulta SQL
    $query = "INSERT INTO composicoes (usuario_id, titulo, texto, data) VALUES (?, ?, ?, NOW())";
    $stmt = $mysqli->prepare($query);

    // Verificar se houve erro ao preparar a consulta
    if ($stmt === false) {
        echo "Erro ao preparar a consulta: " . $mysqli->error;
        exit();
    }

    // Associar os parâmetros e executar
    $stmt->bind_param("iss", $usuario_id, $titulo, $texto);

    if ($stmt->execute()) {
        echo "Composição salva com sucesso!";
    } else {
        echo "Erro: A composição não foi enviada.";
    }

    // Fechar a consulta e a conexão
    $stmt->close();
    $mysqli->close();
} else {
    echo "Por favor, preencha todos os campos.";
}
?>
