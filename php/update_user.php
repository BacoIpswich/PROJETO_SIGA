<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Usuário não está logado, redireciona para a página de login
    header('Location: ../index.php');
    exit;
}

// Conexão com o banco de dados
$host = 'localhost';
$db   = 'login'; // Altere para o nome do seu banco de dados
$user = 'root'; // Usuário padrão para MySQL
$pass = ''; // Sem senha
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

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
    $stmt = $pdo->prepare("UPDATE users SET nome = ?, email = ?, data_nascimento = ?, genero = ?, telefone = ? WHERE cpf = ?");
    $stmt->execute([$nome, $email, $data_nascimento, $genero, $telefone, $cpf]);

    // Verifica se a atualização foi bem-sucedida
    if ($stmt->rowCount() > 0) {
        $_SESSION['mensagem'] = 'Cadastro efetivado com sucesso!';

        // Busca novamente os dados do usuário no banco de dados
        $nova_consulta = $pdo->prepare("SELECT nome, email, data_nascimento, genero, telefone FROM users WHERE cpf = ?");
        $nova_consulta->execute([$cpf]);
        $novo_usuario = $nova_consulta->fetch(PDO::FETCH_ASSOC);

        // Agora você tem os dados atualizados em $novo_usuario
        // Redirecione para a página de perfil ou faça o que for necessário
        header("Location: ../page/perfil.php");
        exit;
    } else {
        echo "Erro ao atualizar os dados.";
    }
}
?>

