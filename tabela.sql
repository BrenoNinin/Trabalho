CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(200) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    usuario VARCHAR(100) NOT NULL,
    sexo VARCHAR(20),
    data_nascimento DATE,
    foto VARCHAR(255)  -- Coluna para armazenar o caminho da imagem
);
