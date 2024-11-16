<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "caneta_de_ouro";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Receber dados do formulário
$email = $_POST['novo_email'];
$senha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);

// Verificar se o e-mail já existe
$sql = "SELECT * FROM usuarios WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "E-mail já cadastrado.";
} else {
    // Inserir novo usuário
    $sql = "INSERT INTO usuarios (email, senha) VALUES ('$email', '$senha')";
    if ($conn->query($sql) === TRUE) {
        echo "Usuário cadastrado com sucesso.";
    } else {
        echo "Erro ao cadastrar usuário: " . $conn->error;
    }
}

$conn->close();
?>