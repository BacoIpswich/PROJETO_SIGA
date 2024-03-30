<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Usuário não está logado, redireciona para a página de login
    header('Location: ../index.php');
    exit;
}

if (isset($_SESSION['mensagem'])) {
    echo '<script>alert("' . $_SESSION['mensagem'] . '");</script>';
    unset($_SESSION['mensagem']); // Limpa a mensagem de sucesso da sessão
}

// // Conexão com o banco de dados
// $host = 'localhost';
// $db   = 'login'; 
// $user = 'root'; 
// $pass = ''; 
// $charset = 'utf8mb4';

// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
// $opt = [
//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//     PDO::ATTR_EMULATE_PREPARES   => false,
// ];
// $pdo = new PDO($dsn, $user, $pass, $opt);

// // Verifica se o formulário foi enviado
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Obtém os dados do formulário
//     $cpf = $_POST['cpf'];
//     $senhaAtual = $_POST['senhaAtual'];
//     $novaSenha = $_POST['senha'];

//     // Busca a senha atual do usuário no banco de dados
//     $stmt = $pdo->prepare("SELECT senha FROM users WHERE cpf = ?");
//     $stmt->execute([$cpf]); // Supondo que $cpf seja a variável com o CPF do usuário
//     $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

//     // Verifica se a senha atual está correta
//     if (password_verify($senhaAtual, $resultado['senha'])) {
//         // Senha atual correta, atualiza a senha no banco de dados
//         $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
//         $stmt = $pdo->prepare("UPDATE users SET senha = ? WHERE cpf = ?");
//         $stmt->execute([$novaSenhaHash, $cpf]);
//         if ($stmt->rowCount() > 0) {
//             $_SESSION['mensagem'] = 'Senha redefinida com sucesso!';
//             header("Location: ../page/perfil.php");
//             exit;
//         } else {
//             $_SESSION['mensagem'] =  "Erro ao atualizar a senha.";
//         }
//     } else {
//         $_SESSION['mensagem'] =  "Senha atual incorreta.";
//     }
// }
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIGA | Configurações</title>

    <!-- Inclua o seu arquivo CSS local aqui -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
    .grid-container{
            display: flex;
            gap: 20%;
            max-width: 70%;
        }
        .formulario-perfil {
            position: relative;
            top: 35%;
            left: 0;
            width: max-content;
            height: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            margin-bottom: 1%;
        }
        .form-group-perfil input, select  {
            width: 450px;
            margin-top: 5px;
            color: #1e7e34;
            border-radius: 5px;
            background-color: #fff;
            font-size: x-large;
            border: 1px solid #ccc;
            outline: none;
            margin-bottom: 5px;
        }
        .form-group-perfil button {
            background-color: #1e7e34;
            color: #fff;
            border-radius: 5px;
            text-align: center;
            font-size: x-large;
            transition: background-color 0.3s ease, color 1.5s ease;
            width: 100%;
            padding: 2%;
            margin-bottom: 6px;
        }
        .form-group-perfil button:hover {
            color: white; /* Cor do texto quando o mouse passa por cima */
            background-color: darkgreen; /* Cor de fundo quando o mouse passa por cima */
        }
        button:disabled, input:disabled, select:disabled {
            background-color: #cccccc88;
            /* color: #ffffff; */
        }
        p{
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <a href="painel.php">
            <img src="../doc/CAPA_FIOCRUZ.png" alt="Capa ini" class="responsive-img">
            </a>
        </header>
        <div>
            <hr>
                <h1>Sistema Intranet de Gerenciamento Almoxarife <br> Configurações</h1>
                <h5 class="login" style="color: #1e7e31;text-align:left">Olá, <?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : ''; ?>   |   <a href="../php/logout.php">Sair</a></h5>
            <hr>
        </div>
        <div class="grid-container">
            <div class="menu-lateral" style="flex: none;">
                <a href="painel.php"><button>Painel</button></a>
                <a href="mascaras_pff_n95.php"><button>Máscara PFF/N95</button></a>
                <a href="documentos.php"><button>Documentos</button></a>
                <a href="blog.php"><button>Blog</button></a>
                <a href="relatorios.php"><button>Relatórios</button></a>
                <a href="perfil.php"><button>Perfil</button></a>
                <a href="suporte.php"><button>Suporte</button></a>
            </div> <!-- fim menu-lateral-->
       
<div class="formulario-perfil"> 

            <form id="perfil-form" method="POST" action="../php/update_senha.php">
                <div class="form-group-perfil">
                
                    <input type="hidden" id="cpf" name="cpf" value="<?php echo $usuario['cpf']; ?>" disabled>
                        <input type="password" id="senhaAtual" name="senhaAtual" placeholder="Senha atual" required>
                    </div><!-- fim senha-->

                    <div class="form-group-perfil">
                        <input type="password" id="senha" name="senha" placeholder="Nova Senha" oninput="validarRegrasSenha();" required>
                    </div><!-- fim nova senha-->

                    <div class="form-group-perfil">
                        <input type="password" id="confirmaSenha" name="confirmaSenha" placeholder="Confirmar Senha" oninput="validarRegrasSenha();" required>
                    
                </div><!-- fim divisao-->
                <ul style="padding-left: 20px;text-align: left;flex: 1;list-style-type: none;margin: 0;"> <!-- Regras de senha -->
                    <li><p id="regraTamanho" class="">Mínimo de 6 caracteres</p></li>
                    <li><p id="regraLetra" class="">Mínimo de 1 letra</p></li>
                    <li><p id="regraEspecial" class="">Mínimo de 1 caractere especial</p></li>
                    <li><p id="regraNumero" class="">Mínimo de 1 número</p></li>
                    <li><p id="regraIgual" class="">Senhas compatíveis</p></li>
                </ul>
                
                    <div class="form-group-perfil" style="display:flow;" >
                        <button type="submit" >Redefinir</button><br>
                        
                    </div><!-- fim form-group-perfil btn--> 
                    </form><!-- fim perfil-form-->
                    <div class="form-group-perfil" style="width: 23.32vw;" >
                    <a href="perfil.php"><button>Cancelar</button></a>
    </div>
            
          
</div><!-- fim formulario-perfil-->
        </div><!-- fim grid-container-->
    </div> <!-- fim conteiner-->

    <!-- JavaScript -->
    <script src="../js/script.js"></script>
    <script>
    function validarSenha(el) {
    var senha = el.value;
    var mensagemErroSenha = document.getElementById('mensagemErroSenha');

    if (senha.length === 0) {
        mensagemErroSenha.textContent = 'Por favor, preencha a senha.';
        return false;
    }

    mensagemErroSenha.textContent = '';
    return true;
}  // -- FINAL FUNCTION validarSenha

function validarRegrasSenha() {
    var senha = document.getElementById('senha').value;
    var confirmaSenha = document.getElementById('confirmaSenha').value;

    // Verifica o comprimento da senha
    if (senha.length >= 6) {
        document.getElementById('regraTamanho').className = 'regraVerde';
    } else {
        document.getElementById('regraTamanho').className = 'regraVermelha';
    }

    // Verifica a presença de uma letra
    if (/[a-zA-Z]/.test(senha)) {
        document.getElementById('regraLetra').className = 'regraVerde';
    } else {
        document.getElementById('regraLetra').className = 'regraVermelha';
    }

    // Verifica a presença de um caractere especial
    if (/[!@#$%^&*]/.test(senha)) {
        document.getElementById('regraEspecial').className = 'regraVerde';
    } else {
        document.getElementById('regraEspecial').className = 'regraVermelha';
    }

    // Verifica a presença de um número
    if (/[0-9]/.test(senha)) {
        document.getElementById('regraNumero').className = 'regraVerde';
    } else {
        document.getElementById('regraNumero').className = 'regraVermelha';
    }
    
    // Verifica se as senhas são iguais
    if (senha === confirmaSenha) {
        document.getElementById('regraIgual').className = 'regraVerde';
    } else {
        document.getElementById('regraIgual').className = 'regraVermelha';
    }
        
}
</script>
</body>
</html>