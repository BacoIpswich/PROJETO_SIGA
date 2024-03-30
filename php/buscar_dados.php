<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Usuário não está logado, redireciona para a página de login
    header('Location: ../index.php');
    exit;
}

// Conexão com o banco de dados
$host = 'localhost';
$db   = 'bd_registro'; 
$user = 'root'; 
$pass = ''; 
$charset = 'utf8mb4';

$mysqli = new mysqli($host, $user, $pass, $db);

// Verificar conexão
if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}

// Obter o CPF do POST
$cpf = $mysqli->real_escape_string($_POST['cpf']);

// Consulta SQL para buscar os dados
$sql = "SELECT * FROM cadastro WHERE cpf = ?";

// Preparar a consulta
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $cpf);

// Executar a consulta
$stmt->execute();

// Obter os resultados
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Retornar os dados como JSON
echo json_encode($data);
