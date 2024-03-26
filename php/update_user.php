<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Usuário não está logado, redireciona para a página de login
    header('Location: ../index.php');
    exit;
}

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

// Obtém o CPF do usuário logado
$cpf = $_SESSION['cpf'];

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $telefone = $_POST['telefone'];

    // Prepara a consulta SQL para atualizar os dados
    $stmt = $mysqli->prepare("UPDATE users SET nome = ?, email = ?, data_nascimento = ?, genero = ?, estado = ?, cidade = ?, telefone = ? WHERE cpf = ?");
    $stmt->bind_param('sssssssi', $nome, $email, $data_nascimento, $genero, $estado, $cidade, $telefone, $cpf);

    // Executa a consulta
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = 'Cadastro efetivado com sucesso!';
        header("Location: ../page/perfil.php");
    } else {
        echo "Erro ao atualizar os dados: " . $stmt->error;
    }

    $stmt->close();
}
$mysqli->close();
?>
