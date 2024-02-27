<?php
// Conexão com o banco de dados
$host = 'localhost';
$db   = 'nome_do_banco_de_dados';
$user = 'nome_do_usuario';
$pass = 'senha';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

// Recupera os dados do formulário
$username = $_POST['username'];
$password = $_POST['password'];

// Prepara a consulta SQL
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->execute([$username, $password]);

// Verifica se a consulta retornou algum resultado
if ($stmt->rowCount() > 0) {
    // Usuário autenticado, redireciona para a página do painel
    header('Location: page/painel.html');
} else {
    // Autenticação falhou, mostra uma mensagem de erro
    echo "Usuário ou senha incorretos.";
}
?>
