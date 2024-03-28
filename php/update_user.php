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

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $telefone = $_POST['telefone'];

    // Prepara a consulta SQL para atualizar os dados
    $stmt = $mysqli->prepare("UPDATE users SET nome = ?, email = ?, data_nascimento = ?, genero = ?, telefone = ? WHERE cpf = ?");
    $stmt->bind_param('sssssi', $nome, $email, $data_nascimento, $genero, $telefone, $cpf);

    // Executa a consulta
    // Após a atualização bem-sucedida
if ($stmt->execute()) {
    $_SESSION['mensagem'] = 'Cadastro efetivado com sucesso!';

    // Busca novamente os dados do usuário no banco de dados
    $nova_consulta = $mysqli->prepare("SELECT nome, email, data_nascimento, genero, telefone FROM users WHERE cpf = ?");
    $nova_consulta->bind_param('i', $cpf); // Supondo que $cpf seja a variável com o CPF do usuário
    $nova_consulta->execute();
    $nova_consulta->bind_result($novo_nome, $novo_email, $nova_data_nascimento, $novo_genero, $novo_telefone);
    $nova_consulta->fetch();

    // Agora você tem os dados atualizados em $novo_nome, $novo_email, etc.
    // Redirecione para a página de perfil ou faça o que for necessário
    header("Location: ../page/perfil.php");
} else {
    echo "Erro ao atualizar os dados: " . $stmt->error;
}

$stmt->close();
$nova_consulta->close();
$mysqli->close();


    $stmt->close();
}
$mysqli->close();
?>
