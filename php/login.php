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

// Verifica se o CPF e a senha foram postados
if (isset($_POST['cpf']) && isset($_POST['senha'])) {
    // Recupera os dados do formulário
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    // Prepara a consulta SQL
    $stmt = $pdo->prepare("SELECT * FROM users WHERE cpf = ?");
    $stmt->execute([$cpf]);

    // Verifica se a consulta retornou algum resultado
    if ($stmt->rowCount() > 0) {
        // Recupera os dados do usuário
        $user = $stmt->fetch();

        // Verifica a senha
        if (password_verify($senha, $user['senha'])) {
            // A senha está correta

            // Usuário autenticado, define as variáveis de sessão
            $_SESSION['logado'] = true;
            $_SESSION['nome'] = $user['nome'];

            // Redireciona para a página do painel
            header('Location: ../page/painel.php');
            exit;
        } else {
            // A senha está incorreta
            $_SESSION['erro'] = "Usuário ou Senha incorretos.";
        }
    } else {
        // O usuário não existe
        $_SESSION['erro'] = "Usuário ou Senha incorretos.";
    }

    // Redireciona de volta para a página de login
    header('Location: ../index.php');
    exit;
}
?>
