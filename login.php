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

// Consultar o banco de dados para obter os dados do usuário
$query = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
    
    // Verificar se a senha digitada corresponde ao hash armazenado no banco
    if (password_verify($senha, $usuario['senha'])) {
        // A senha é válida, inicie a sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['nome_usuario'] = $usuario['usuario'];
        
        // Redirecionar para a página de boas-vindas (comeco.php)
        header("Location: comeco.php");
        exit();
    } else {
        echo "E-mail ou senha incorretos!";
    }
} else {
    echo "E-mail ou senha incorretos!";
}
?>
