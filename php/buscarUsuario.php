<?php
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

function buscarUsuario($cpf) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM cadastro WHERE cpf = ?");
    $stmt->execute([$cpf]);
    $user = $stmt->fetch();
    return $user ? $user : false;
}

// Verifica se o CPF foi enviado via POST
if (isset($_POST['cpf'])) {
    $cpf = $_POST['cpf'];
    $user = buscarUsuario($cpf);

    // Retorna os dados do usuário em formato JSON
    echo json_encode($user);
}
?>
