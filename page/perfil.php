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

// Obtém o CPF do usuário logado
$cpf = $_SESSION['cpf'];

// Busca os dados do usuário no banco de dados
$sql = "SELECT * FROM users WHERE cpf = '$cpf'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // Armazena os dados do usuário em uma variável
    $usuario = $result->fetch_assoc();
} else {
    echo "Nenhum usuário encontrado com o CPF: $cpf";
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIGA | Perfil</title>

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
            margin-top: 20px;
            color: #1e7e34;
            border-radius: 5px;
            background-color: #fff;
            font-size: x-large;
            border: 1px solid #ccc;
            outline: none;
            margin-bottom: 20px;
        }
        .form-group-perfil button {
            background-color: #1e7e34;
            color: #fff;
            border-radius: 5px;
            text-align: center;
            font-size: x-large;
            transition: background-color 0.3s ease, color 1.5s ease;
            width: 150%;
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
                <h1>Sistema Intranet de Gerenciamento Almoxarife <br> Perfil</h1>
                <h5 class="login" style="color: #1e7e31;text-align:left">Olá, <?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : ''; ?>   |   <a href="../php/logout.php">Sair</a></h5>
            <hr>
        </div>
        <div class="grid-container">
            <div class="menu-lateral">
                <a href="painel.php"><button>Painel</button></a>
                <a href="mascaras_pff_n95.php"><button>Máscara PFF/N95</button></a>
                <a href="documentos.php"><button>Documentos</button></a>
                <a href="blog.php"><button>Blog</button></a>
                <a href="relatorios.php"><button>Relatórios</button></a>
                <a href="perfil.php"><button>Perfil</button></a>
                <a href="suporte.php"><button>Suporte</button></a>
            </div> <!-- fim menu-lateral-->
       
<div class="formulario-perfil"> 
    <div class="row">
        <div class="col">
            <form id="perfil-form" method="POST" action="../php/update_user.php">
                <div class="form-group-perfil">
                <input type="hidden" id="cpf" name="cpf" value="<?php echo $usuario['cpf']; ?>" disabled>
                    <input type="text" id="nome" name="nome" required value="<?php echo $usuario['nome']; ?>" disabled placeholder="Nome">
                </div><!-- fim nome-->

                <div class="form-group-perfil">
                    <input autocomplete="off" type="email" id="email" name="email" required value="<?php echo $usuario['email']; ?>" disabled placeholder="E-mail">
                </div><!-- fim email-->

                <div class="form-group-perfil">
                    <input type="date" id="data_nascimento" name="data_nascimento"  value="<?php echo $usuario['data_nascimento']; ?>" disabled placeholder="Data de Nascimento">
                </div><!-- fim data_nascimento-->

                <div class="form-group-perfil">
                    <select id="genero" name="genero" disabled placeholder="Gênero">
                    <?php
                        $generos = array(
                            "Masculino",
                            "Feminino",
                            "Outro",
                            "Prefiro não dizer"
                        );

                        foreach ($generos as $genero) {
                            $selected = ($usuario['genero'] === $genero) ? 'selected' : '';
                            echo "<option value=\"$genero\" $selected>$genero</option>";
                        }
                    ?>
                    </select>
                </div><!-- fim genero-->

                <div class="form-group-perfil">
                    <input type="tel" id="telefone" name="telefone" value="<?php echo $usuario['telefone']; ?>" disabled placeholder="Telefone">
                </div><!-- fim telefone-->
        </div><!-- fim col 1-->

                <div class="col" style="left: 50%;">
                <div class="form-group-perfil" style="display:flow;" >
                    <button type="button" id="editar-btn" >Editar</button><br>
                    <button type="button" id="senha-btn"><a for="senha-btn" href="senha.php" style="color:#fff;text-decoration: none;">Trocar Senha</a></button><br>
                    <button type="submit" id="salvar-btn"  disabled>Salvar</button><br>
                    <button type="button" id="cancelar-btn"  disabled>Cancelar</button>
                    </div><!-- fim form-group-perfil btn--> 
            </div><!-- fim col 2-->
    
            </form><!-- fim perfil-form-->
        </div><!-- fim row 2-->   
</div><!-- fim formulario-perfil-->
        </div><!-- fim grid-container-->
    </div> <!-- fim conteiner-->

    <!-- JavaScript -->
    <script src="../js/script.js"></script>
    <script>
document.getElementById('editar-btn').addEventListener('click', function() {
    // Habilita os campos do formulário
    var campos = document.querySelectorAll('#perfil-form input, #perfil-form select');
    campos.forEach(function(campo) {
        campo.disabled = false;
        campo.style.Color = "#cccccc88"; // Cor original
    });

    // Habilita os botões "Salvar" e "Cancelar"
    var salvarBtn = document.getElementById('salvar-btn');
    salvarBtn.disabled = false;
    salvarBtn.style.backgroundColor = "#1e7e34"; // Cor original
    salvarBtn.style.color = "#ffffff"; // Cor original

    var cancelarBtn = document.getElementById('cancelar-btn');
    cancelarBtn.disabled = false;
    cancelarBtn.style.backgroundColor = "#1e7e34"; // Cor original
    cancelarBtn.style.color = "#ffffff"; // Cor original

    // Muda a cor do botão "Editar"
    var editarBtn = document.getElementById('editar-btn');
    editarBtn.style.backgroundColor = "#cccccc88"; // Nova cor
    editarBtn.style.color = "#ffffff"; // Nova cor

    var senhaBtn = document.getElementById('senha-btn');
    senhaBtn.disabled = true;
    senhaBtn.style.backgroundColor = "#cccccc88"; // Nova cor
    senhaBtn.style.color = "#ffffff"; // Nova cor
    senhaBtn.innerHTML = 'Trocar Senha';
});

document.getElementById('cancelar-btn').addEventListener('click', function() {
    // Desabilita os campos do formulário
    var campos = document.querySelectorAll('#perfil-form input, #perfil-form select');
    campos.forEach(function(campo) {
        campo.disabled = true;
        campo.style.Color = "#1e7e34"; // Cor original
    });

    // Desabilita os botões "Salvar" e "Cancelar"
    var salvarBtn = document.getElementById('salvar-btn');
    salvarBtn.disabled = true;
    salvarBtn.style.backgroundColor = "#cccccc88"; // Nova cor
    salvarBtn.style.color = "#ffffff"; // Nova cor

    var cancelarBtn = document.getElementById('cancelar-btn');
    cancelarBtn.disabled = true;
    cancelarBtn.style.backgroundColor = "#cccccc88"; // Nova cor
    cancelarBtn.style.color = "#ffffff"; // Nova cor

    // Muda a cor do botão "Editar" de volta para a original
    var editarBtn = document.getElementById('editar-btn');
    editarBtn.style.backgroundColor = "#1e7e34"; // Cor original
    editarBtn.style.color = "#ffffff"; // Cor original

    var senhaBtn = document.getElementById('senha-btn');
    senhaBtn.disabled = false;
    senhaBtn.style.backgroundColor = "#1e7e34"; // Nova cor
    senhaBtn.style.color = "#ffffff"; // Nova cor
    senhaBtn.innerHTML = '<a href="senha.php" style="color:#fff;text-decoration: none;">Trocar Senha</a>';
});

    </script>
</body>
</html>