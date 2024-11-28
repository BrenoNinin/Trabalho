<?php
// Iniciar a sessão
session_start();

// Conectar ao banco de dados
$hostname = "localhost";
$bancodedados = "caneta_de_ouro";
$usuario = "root";
$senha = "";
$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);

// Verificar a conexão
if ($mysqli->connect_errno) {
    echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}

// Receber os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];
$usuario_nome = $_POST['usuario'];
$sexo = $_POST['sexo'];
$data_nascimento = $_POST['data_nascimento'];

// Verificar se as senhas coincidem
if ($senha != $confirmar_senha) {
    echo "As senhas não coincidem!";
    exit();
}

// Criptografar a senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Inserir no banco de dados
$query = "INSERT INTO usuarios (email, senha, usuario, sexo, data_nascimento) VALUES (?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("sssss", $email, $senha_hash, $usuario_nome, $sexo, $data_nascimento);

if ($stmt->execute()) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar usuário!";
}
?>
