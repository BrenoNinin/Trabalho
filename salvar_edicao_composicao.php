<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: inscricao.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$composicao_id = $_POST['id']; // ID da composição a ser editada
$novo_texto = $_POST['texto']; // Novo texto da composição

// Conectar ao banco de dados
$mysqli = new mysqli("localhost", "root", "", "caneta_de_ouro");
if ($mysqli->connect_errno) {
    echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}

// Atualizar a composição no banco de dados
$query = "UPDATE composicoes SET texto = ? WHERE id = ? AND usuario_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("sii", $novo_texto, $composicao_id, $usuario_id);

if ($stmt->execute()) {
    echo "Composição atualizada com sucesso!";
    header("Location: minhas_composicoes.php");
    exit();
} else {
    echo "Erro ao atualizar composição: " . $stmt->error;
}
?>
