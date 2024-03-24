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
   
    <!-- Titulo -->
    <title>SIGA | Perfil</title>

    <!-- Inclua o seu arquivo CSS local aqui -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">

    <style>
        .grid-container{
            display: flex;
            gap: 25%;
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
            margin-top: 19px;
            color: #1e7e34;
            border-radius: 5px;
            background-color: #fff;
            font-size: x-large;
            border: 1px solid #ccc;
            outline: none;
        }

        .form-group-perfil button {
            background-color: #1e7e34;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            text-align: center;
            width: 250%;
            margin-top: 15px;
            margin-right: 15px;
            margin
        }

        .form-group-perfil span{
            position: absolute;
            left: 5px;
            margin-top: 5px;
            background-color: #fff;
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
            </div>
       

        <!-- Seu conteúdo vai aqui -->
         <div class="formulario-perfil"> 
        <form id="perfil-form">
                <div class="form-group-perfil">
                    <input autocomplete="off" type="text" id="nome" name="nome" required value="<?php echo $usuario['nome']; ?>" disabled>
                    <span>Nome:</span><br>
                </div>
                <div class="form-group-perfil">
                    <input autocomplete="off" type="email" id="email" name="email" required value="<?php echo $usuario['email']; ?>" disabled>
                    <span>E-mail:</span><br>
                </div>
                <div class="form-group-perfil">
                    <input autocomplete="off" type="date" id="data_nascimento" name="data_nascimento"  value="<?php echo $usuario['data_nascimento']; ?>" disabled>
                    <span>Data de Nascimento:</span><br>
                </div>

                    <div class="form-group-perfil">
                        <select autocomplete="off" id="genero" name="genero" disabled>
                            <option value="NULL"></option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                            <option value="Outro">Outro</option>
                            <option value="Prefiro não dizer">Prefiro não dizer</option>
                            <!-- Adicione aqui as outras opções -->
                        </select>
                        <span>Gênero:</span><br>
                    </div>
                    <div class="form-group-perfil">
                        <select autocomplete="off" id="estado" name="estado" disabled onchange="updateCidades()">
                            <option value="rj">Rio de Janeiro</option>
                            <option value="sp">São Paulo</option>
                            <!-- Adicione aqui as outras opções -->
                        </select>
                        <span>Estado:</span><br>
                    </div>

                    <div class="form-group-perfil">
                        <select autocomplete="off" id="cidade" name="cidade" disabled>
                        
                            <!-- As opções serão preenchidas dinamicamente com JavaScript -->
                        </select>
                        <span>Cidade:</span><br>
                    </div>
                <div class="form-group-perfil">
                    <input autocomplete="off" type="tel" id="telefone" name="telefone" value="<?php echo $usuario['telefone']; ?>" disabled>
                    <span>Telefone:</span><br>
                </div>
                <!-- Para a foto do perfil, você precisará de um manejo especial para exibir e atualizar a imagem -->
                </div>

                <div class="form-group-perfil">
                    <button type="button" id="editar-btn">Editar</button><br><br>
                    <button type="submit" id="salvar-btn" disabled>Salvar</button><br><br>
                    <button type="button" id="cancelar-btn" disabled>Cancelar</button>
                </div>
                

        
        </form>
        </div>
        </div>

    </div>

    <!-- JavaScript -->
    <script src="../js/script.js"></script>
    <script>
    document.getElementById('editar-btn').addEventListener('click', function() {
        // Habilita os campos do formulário
        var campos = document.querySelectorAll('#perfil-form input, #perfil-form select');
        campos.forEach(function(campo) {
            campo.disabled = false;
        });

        // Habilita os botões "Salvar" e "Cancelar"
        document.getElementById('salvar-btn').disabled = false;
        document.getElementById('cancelar-btn').disabled = false;
    });

    document.getElementById('cancelar-btn').addEventListener('click', function() {
        // Desabilita os campos do formulário
        var campos = document.querySelectorAll('#perfil-form input, #perfil-form select');
        campos.forEach(function(campo) {
            campo.disabled = true;
        });

        // Desabilita os botões "Salvar" e "Cancelar"
        document.getElementById('salvar-btn').disabled = true;
        document.getElementById('cancelar-btn').disabled = true;

        // Recarrega a página para reverter as alterações
        location.reload();
    });

    function updateCidades() {
    var estado = document.getElementById('estado').value;
    var cidade = document.getElementById('cidade');

    // Limpa as opções existentes
    cidade.innerHTML = '';

    if (estado == 'rj') {
        // Adiciona as cidades do Rio de Janeiro
        cidade.options.add(new Option('Rio de Janeiro', 'rio_de_janeiro'));
        cidade.options.add(new Option('Niterói', 'niteroi'));
        // Adicione aqui as outras cidades
    } else if (estado == 'sp') {
        // Adiciona as cidades de São Paulo
        cidade.options.add(new Option('São Paulo', 'sao_paulo'));
        cidade.options.add(new Option('Campinas', 'campinas'));
        // Adicione aqui as outras cidades
    }

    // Adicione aqui os outros estados e suas cidades
}

    </script>
</body>
</html>