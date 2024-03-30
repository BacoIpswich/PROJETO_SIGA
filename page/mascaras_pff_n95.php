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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <!-- Titulo -->
    <title>SIGA | Registro de PFF/N95</title>

    <!-- Inclua o seu arquivo CSS local aqui -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            text-align: center;
            background-color: #1e7e34;
            color: #1e7e34;
        }

        .responsive-img {
            margin-top: 5px;
            width: 100%;
            height: auto;
        }

        .container {
            max-width: 80%;
            min-height: 95vh;
            margin: 20px auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            border-radius: 15px;
            background-color: #fff;
            overflow: auto;
        }

        .form-group {
            margin-bottom: 10px;
            padding: 0px 20px 0px 0px;
            border-radius: 5px;
            text-align: center;
        }

        .form-group input[type="submit"] {
            background-color: #1e7e34;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            text-align: center;
        }

        .form-group input[type="submit"]:hover {
            background-color: darkgreen;
            border-radius: 5px;
            text-align: center;
        }

        .menu-lateral {
            position: relative;
            top: 30%;
            left: 0;
            width: max-content;
            height: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            margin-bottom: 1%;
        }
            
        .menu-lateral button {
            margin-bottom: 1%;
            width: 300px;
            padding: 2%;
            margin-top: 1%;
            color: #fff;
            text-align: center;
            font-size: x-large;
            background-color: #1e7e34;
            transition: background-color 0.3s ease, color 1.5s ease;
            border-radius: 5px; 
        }
            
        .menu-lateral button:hover {
            background-color: darkgreen; /* Cor de fundo quando o mouse passa por cima */
        }

        .login { 
            margin: 0 !important;
            color: #1e7e34 !important;
        }
            
        .regraVermelha {
            color: red;
            margin:0px;
        }
            
        .regraVerde {
            color: #1e7e34;
            margin:0px;
        }
        .grid-container{
            display: flex;
            gap: 20%;
            max-width: 100%;
            justify-content: flex-start;
            }
        .formulario-perfil {
            position: relative;
            top: 35%;
            left: 0;
            display: flex;
            flex-direction: column;
            margin-bottom: 1%;    
            }
        .form-group input  {
            width: 200%;
            margin-top: 5px;
            color: #1e7e34;
            text-align: center;
            font-size: x-large;
            }
        .form-group select  {
            width: 200%;
            margin-top: 5px;
            color: #1e7e34;
            text-align: center;
            font-size: x-large;
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
            flex: 1;
            }
        .form-group-perfil button:hover {
            color: white; /* Cor do texto quando o mouse passa por cima */
            background-color: darkgreen; /* Cor de fundo quando o mouse passa por cima */
            }
        .form-hr {
            width: 180%;
            margin: -1px;
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
                <h1>Sistema Intranet de Gerenciamento Almoxarife <br> Registro de PFF/N95</h1>
                <h5 class="login" style="color: #1e7e31;text-align:left">Olá, <?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : ''; ?> |   <a href="../php/logout.php">Sair</a></h5>
            <hr>
        </div> <!-- fim cabeçalho -->
        <div class="grid-container">
        <div class="menu-lateral">
            <a href="painel.php"><button>Painel</button></a>
            <a href="mascaras_pff_n95.php"><button>Máscara PFF/N95</button></a>
            <a href="documentos.php"><button>Documentos</button></a>
            <a href="blog.php"><button>Blog</button></a>
            <a href="relatorios.php"><button>Relatórios</button></a>
            <a href="perfil.php"><button>Perfil</button></a>
            <a href="suporte.php"><button>Suporte</button></a>
        </div><!-- fim menu-lateral -->
    <div class="formulario-perfil"> 
    <div class="row">
        <div class="col">

            <form id="perfil-form" method="POST" action="">

            <div class="form-group"> <!-- Campo CPF -->
                <input type="text" placeholder="CPF" id="cpf" name="cpf" onkeyup="formatarCPF(this);" onblur="validarCPF(this)" maxlength="14" required="" oninput="verificarCamposPreenchidos();">
            </div> <!-- fim do campo CPF-->
            

            <hr class="form-hr">

            <div class="form-group" > <!-- Campo retorno cadastro -->
                <input autocomplete="off" type="text" id="nome" name="nome" value="" placeholder="Nome" style="text-align: justify;" required disabled><br>
                <input autocomplete="off" type="text" id="setor" name="setor" value="" placeholder="Setor" style="text-align: justify;" required disabled><br>
                <input autocomplete="off" type="text" id="empresa" name="empresa" value="" placeholder="Empresa" style="text-align: justify;" required disabled><br>
                <p id="mensagemErroCadastro" class="regraVermelha"></p>
            </div><!-- fim retorno cadastro-->

            <hr class="form-hr">

            <div class="form-group" > <!-- Campo retorno controle -->
                <input autocomplete="off" type="text" id="data_registro" name="data_registro" value="" placeholder="Ultima Retirada" required disabled><br>
                <input autocomplete="off" type="text" id="status" name="status" value="" placeholder="Status" required disabled><br>
                <p id="mensagemErroControle" class="regraVermelha"></p>
            </div><!-- fim retorno controle -->

            <hr class="form-hr">

            <div class="form-group" > <!-- Campo Justificativa -->
                <select id="justificativa" name="justificativa" disabled placeholder="Justificativas">
                    <option value="SUJA/MOLHADA">SUJA/MOLHADA</option>
                    <option value="LIBERADO">LIBERADO</option>
                    <option value="ESQUECI/PERDI">ESQUECI/PERDI</option>
                    <option value="DEFEITUOSA">DEFEITUOSA</option>
                    <option value="CAIU NO CHÃO">CAIU NO CHÃO</option>
                    <option value="CADASTRO NOVO">CADASTRO NOVO</option>
                    <option value="VISITANTE">VISITANTE</option>
                </select><br>
                <input autocomplete="off" type="number" id="quantidade" name="quantidade" value="1" placeholder="Quantidade" required disabled><br>
                <p id="mensagemErroJustificativa" class="regraVermelha"></p>
            </div><!-- fim Justificativa-->

            <hr class="form-hr">

        </div><!-- fim col 1-->
                <div class="col" style="left: 60%;">
                
                <div class="form-group-perfil">
                    <button type="submit" id="dispensar-btn" >Dispensar</button><br>
                    
                    <br>
                    <button type="button" id="novo-btn">Novo</button><br>
                    <br>
                    <button type="button" id="atualizar-btn">Atualizar</button><br>
                    <button type="button" id="limpar-btn">Limpar</button>
                    </div><!-- fim form-group-perfil btn--> 
                    <p id="mensagemErroCPF" class="regraVermelha" style="text-align: end;"></p>
            </div><!-- fim col 2-->

            
            </form><!-- fim perfil-form-->
            
        </div><!-- fim row 2-->   
</div><!-- fim formulario-perfil-->
        </div><!-- fim grid-container-->
    </div> <!-- fim conteiner-->

    <!-- JavaScript -->
<script src="../js/script.js"></script>
<script src="../js/cpf.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
// Definindo a variável do usuário logado
var usuario_cadastrou = "<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>";
console.log('Usuário cadastrou:', usuario_cadastrou); // Adicione esta linha

$(document).ready(function() {
    $('#cpf').blur(function(){
    var cpf = $(this).val();

    if (cpf === '') {
        // Se o CPF estiver vazio, limpa os campos do formulário
        $('#nome').val('');
        $('#setor').val('');
        $('#empresa').val('');
        $('input').on('input', function() {
    this.value = this.value.toUpperCase();
});
    } else if (validarCPF(cpf)) { // Adicione a verificação de validade do CPF aqui
        $.ajax({
            url: '../php/buscarUsuario.php',
            type: 'POST',
            data: {cpf: cpf},
            success: function(data){
                console.log(data); // Para depuração
                // Supondo que os dados retornados estão em formato JSON
                var dados = JSON.parse(data);

                if (dados) {
                    // Se os dados foram retornados, preenche os campos
                    $('#nome').val(dados.nome);
                    $('#setor').val(dados.setor);
                    $('#empresa').val(dados.empresa);
                    
                    // Desativa os campos do formulário
                    $('#cpf').prop('disabled', true);
                    $('#nome').prop('disabled', true);
                    $('#setor').prop('disabled', true);
                    $('#empresa').prop('disabled', true);
                    
                    // Ativa os campos de justificativa
                    $('#justificativa').prop('disabled', false);
                    $('#quantidade').prop('disabled', true);
                } else {
                    // Se não foram retornados dados, desbloqueia os campos para cadastro
                    $('#nome').prop('disabled', false);
                    $('#setor').prop('disabled', false);
                    $('#empresa').prop('disabled', false);
                }
            }
        });
    } else {
        // Se o CPF for inválido, limpa os campos do formulário
        $('#nome').val('');
        $('#setor').val('');
        $('#empresa').val('');
        // Mantém os campos do formulário desativados
        $('#nome').prop('disabled', true);
        $('#setor').prop('disabled', true);
        $('#empresa').prop('disabled', true);
    }
});


$('#justificativa').change(function() {
    // Verifica se o valor é "Visitante"
    if ($(this).val() === 'Visitante') {
        // Desbloqueia o campo #quantidade
        $('#quantidade').prop('disabled', false);
    } else {
        // Bloqueia o campo #quantidade e define o valor padrão
        $('#quantidade').prop('disabled', true).val(1);
    }
});


    $('#novo-btn').click(function(e){
        e.preventDefault(); // Impede o envio do formulário

        var cpf = $('#cpf').val();
        var nome = $('#nome').val();
        var setor = $('#setor').val();
        var empresa = $('#empresa').val();

        $.ajax({
            url: '../php/inserirUsuario.php',
            type: 'POST',
            data: {cpf: cpf, nome: nome, setor: setor, empresa: empresa, usuario_cadastrou: usuario_cadastrou},
            success: function(data){
                alert('Usuário cadastrado com sucesso!');
                
                // Preenche os campos do formulário com os dados retornados
                $('#cpf').val(data.cpf);
                $('#nome').val(data.nome);
                $('#setor').val(data.setor);
                $('#empresa').val(data.empresa);
                
                // Desativa os campos do formulário
                $('#cpf').prop('disabled', true);
                $('#nome').prop('disabled', true);
                $('#setor').prop('disabled', true);
                $('#empresa').prop('disabled', true);
                
                // Ativa os campos de justificativa
                $('#justificativa').prop('disabled', false);
                $('#quantidade').prop('disabled', false);
            }
        });
    });

    $('#limpar-btn').click(function(){
        // Limpa os campos
        $('#cpf').val('');
        $('#nome').val('');
        $('#setor').val('');
        $('#empresa').val('');
        $('#justificativa').val('Justificativas');
        $('#quantidade').val('');
        // Desabilita os campos
        $('#cpf').prop('disabled', false);
        $('#nome').prop('disabled', true);
        $('#setor').prop('disabled', true);
        $('#empresa').prop('disabled', true);
        $('#justificativa').prop('disabled', true);
        $('#quantidade').prop('disabled', true);
        $('#mensagemErroCPF').text('');
        // Coloca o foco no campo CPF
        $('#cpf').focus();
    });
});

$('input').on('input', function() {
    this.value = this.value.toUpperCase();
});

$('#cpf').on('input', function() {
    // Limpa a mensagem de erro quando o CPF é alterado
    $('#mensagemErroCPF').text('');
});


$('form').submit(function(e) {
    // Verifica se os campos necessários estão preenchidos
    if ($('#cpf').val() === '' || $('#nome').val() === '' || $('#setor').val() === '' || $('#empresa').val() === '') {
        e.preventDefault(); // Impede o envio do formulário
        alert('Por favor, preencha todos os campos necessários.');
    }
});
</script>


</body>
</html>