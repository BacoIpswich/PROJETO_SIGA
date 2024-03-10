<?php
// Inicia a sessão
session_start();

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

// Verifique se o CPF e o e-mail foram postados
if (isset($_POST['cpf']) && isset($_POST['email'])) {
    // Recupera os dados do formulário
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];

    // Prepara a consulta SQL
    $stmt = $pdo->prepare("SELECT * FROM users WHERE cpf = ? AND email = ?");
    $stmt->execute([$cpf, $email]);
}
    // Verifique se a consulta retornou algum resultado
    if ($stmt->rowCount() > 0) {
        // Recupera os dados do usuário
        $user = $stmt->fetch();
    
        // Usuário autenticado, define as variáveis de sessão
        $_SESSION['logado'] = true;
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['cpf'] = $cpf;
        $_SESSION['email'] = $email;
    
        // Redireciona para a página de confirmação de dados
        header('Location: ../page/confirmacao_dados.php');
        exit;
    } else {
        
    $_SESSION['mensagem'] = "Usuário ou Senha incorretos.";

    // Redireciona para a página de login
    header('Location: ../index.php');
    exit;
}
?>


