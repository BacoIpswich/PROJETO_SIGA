<?php

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Usuário não está logado, redireciona para a página de login
    header('Location: ../index.php');
    exit;
}

$host = 'localhost';
$db   = 'bd_registro'; 
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

function inserirUsuario($cpf, $nome, $setor, $empresa, $usuario_cadastrou) {
    global $pdo;
    $data_cadastro = date('Y-m-d H:i:s'); // Pega a data e hora atual
    $stmt = $pdo->prepare("INSERT INTO cadastro (cpf, nome, setor, empresa, data_cadastro, usuario_cadastrou, data_atualizacao, usuario_editou) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$cpf, $nome, $setor, $empresa, $data_cadastro, $usuario_cadastrou, $data_cadastro, $usuario_cadastrou]);

    // Retorna os dados do usuário
    return ['cpf' => $cpf, 'nome' => $nome, 'setor' => $setor, 'empresa' => $empresa];
}

// Verifica se os dados do usuário foram enviados via POST
if (isset($_POST['cpf'], $_POST['nome'], $_POST['setor'], $_POST['empresa'], $_POST['usuario_cadastrou'])) {
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $setor = $_POST['setor'];
    $empresa = $_POST['empresa'];
    $usuario_cadastrou = $_POST['usuario_cadastrou'];
    $dados = inserirUsuario($cpf, $nome, $setor, $empresa, $usuario_cadastrou);

    // Envia os dados do usuário como resposta
    echo json_encode($dados);
}

