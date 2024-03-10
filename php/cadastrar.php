<?php
session_start(); // Inicia a sessão

// Conexão com o banco de dados
$host = 'localhost';
$db   = 'login'; 
$user = 'root'; 
$pass = ''; 
$charset = 'utf8mb4';

$mysqli = new mysqli($host, $user, $pass, $db);

// Verifica a conexão
if ($mysqli->connect_error) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

// Obtém os dados do formulário
$nome = $mysqli->real_escape_string($_POST['nome']);
$cpf = $mysqli->real_escape_string($_POST['cpf']);
$email = $mysqli->real_escape_string($_POST['email']);
$senha = $mysqli->real_escape_string($_POST['senha']);
$nivel_acesso = 3; // Nível de acesso padrão

// Verifica se o usuário já existe
$sql = "SELECT * FROM users WHERE email = '$email' OR cpf = '$cpf'";
if ($result = $mysqli->query($sql)) {
    if ($result->num_rows > 0) {
        // O usuário já existe, armazena a mensagem de erro na sessão e redireciona para a página de login
        $_SESSION['erro'] = 'Este usuário já existe!';
        header("Location: ../index.php");
        exit;
    } else {
        // O usuário não existe, cria a consulta SQL para inserir o novo usuário
        $sql = "INSERT INTO users (nome, cpf, email, senha, nivel_acesso) VALUES ('$nome', '$cpf', '$email', '$senha', '$nivel_acesso')";

        // Executa a consulta
        if ($mysqli->query($sql) === TRUE) {
            $_SESSION['sucesso'] = 'Cadastro efetivado com sucesso!';
            // Redireciona para a página de login
            header("Location: ../index.php");
            exit;
        } else {
            echo "Erro ao inserir o usuário: " . $mysqli->error;
        }
    }
} else {
    echo "Erro ao verificar a existência do usuário: " . $mysqli->error;
}

// Fecha a conexão
$mysqli->close();
?>

