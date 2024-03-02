<?php
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
$senha = $mysqli->real_escape_string($_POST['senha']);
$nivel_acesso = 3; // Nível de acesso padrão

// Cria a consulta SQL
$sql = "INSERT INTO nome_da_tabela (nome, cpf, senha, nivel_acesso) VALUES ('$nome', '$cpf', '$senha', '$nivel_acesso')";

// Executa a consulta
if ($mysqli->query($sql) === TRUE) {
    // Redireciona para a página de login
    header("Location: ../index.php");
    exit;
} else {
    echo "Erro: " . $sql . "<br>" . $mysqli->error;
}

// Fecha a conexão
$mysqli->close();
?>
