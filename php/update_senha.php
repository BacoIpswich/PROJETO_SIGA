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
    $senhaAtual = $_POST['senhaAtual'];
    $novaSenha = $_POST['senha'];
    $cpf = $_SESSION['cpf']; // Obtém o CPF do usuário logado

    // Busca a senha atual do usuário no banco de dados
    $stmt = $pdo->prepare("SELECT senha FROM users WHERE cpf = ?");
    $stmt->execute([$cpf]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se a senha atual está correta
    if (password_verify($senhaAtual, $resultado['senha'])) {
        // Senha atual correta, atualiza a senha no banco de dados
        $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET senha = ? WHERE cpf = ?");
        $stmt->execute([$novaSenhaHash, $cpf]);
        if ($stmt->rowCount() > 0) {
            $_SESSION['mensagem'] = 'Senha redefinida com sucesso!';
            header("Location: ../page/perfil.php");
            exit;
        } else {
            $_SESSION['mensagem'] =  "Erro ao atualizar a senha.";
        }
    } else {
        $_SESSION['mensagem'] =  "Senha atual incorreta.";
    }
}
?>
