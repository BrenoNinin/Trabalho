<?php
$host = 'localhost';  // Seu host
$usuario = 'root';    // Seu usuário do banco de dados
$senha = '';          // Sua senha do banco de dados
$banco = 'caneta_de_ouro';  // Nome do banco de dados

// Cria a conexão
$mysqli = new mysqli($host, $usuario, $senha, $banco);

// Verifica se a conexão foi bem-sucedida
if ($mysqli->connect_error) {
    die("Falha na conexão: " . $mysqli->connect_error);
}
?>
