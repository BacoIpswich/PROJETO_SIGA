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

// Verifique se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera o CPF da sessão
    $cpf = $_SESSION['cpf'];

    // Verifica se o CPF está na sessão
    if (!isset($cpf)) {
        echo 'CPF não encontrado na sessão.<br>';
        exit;
    }

    // Remove os traços e pontos do CPF para a nova senha
    $cpf_editado = str_replace(['.', '-'], '', $cpf);

    // Define a nova senha
    $senha = "senha@$cpf_editado";

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Prepara a consulta SQL para atualizar a senha
    $stmt = $pdo->prepare("UPDATE users SET senha = ? WHERE cpf = ?");
    $result = $stmt->execute([$senha_hash, $cpf]);

    if ($result) {
        echo 'A senha foi alterada com sucesso no banco de dados.<br>';

        // Define a mensagem de sucesso
        $_SESSION['mensagem'] = 'Senha alterada com sucesso! para senha@(seu cpf)';

        // Redireciona para a página de login
        header('Location: ../index.php');
        exit;
    } else {
        echo 'A senha não pôde ser alterada no banco de dados.<br>';
        // Imprime o erro
        print_r($stmt->errorInfo());
    }
}
?>