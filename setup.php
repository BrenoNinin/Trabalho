<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "seu_usuario";  // Usuário do banco de dados
$password = "sua_senha";    // Senha do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Criar o banco de dados
$sql = "CREATE DATABASE IF NOT EXISTS caneta_de_ouro";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados criado com sucesso.<br>";
} else {
    echo "Erro ao criar banco de dados: " . $conn->error;
}

// Selecionar o banco de dados
$conn->select_db("caneta_de_ouro");

// Criar a tabela de usuários
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    email VARCHAR(200) NOT NULL,
    senha VARCHAR(200) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabela 'usuarios' criada com sucesso.";
} else {
    echo "Erro ao criar tabela: " . $conn->error;
}

// Fechar conexão
$conn->close();
?>
