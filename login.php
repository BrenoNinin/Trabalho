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
$email = $_POST['email'];
$senha = $_POST['senha'];

// Verificar se o e-mail e a senha são válidos
$sql = "SELECT * FROM usuarios WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($senha, $row['senha'])) {
        echo "Login bem-sucedido!";
        // Redirecionar para a página principal
        header("Location: comeco.html");
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "E-mail não encontrado.";
}

$conn->close();
?>
