<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Usuário não está logado, redireciona para a página de login
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <!-- Titulo -->
    <title>SIGA | Blog</title>

    <!-- Inclua o seu arquivo CSS local aqui -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">

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
                <h1>Sistema Intranet de Gerenciamento Almoxarife <br> Informativos</h1>
                <h5 class="login" style="color: #1e7e31;text-align:left">Olá, <?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : ''; ?>   |   <a href="../php/logout.php">Sair</a></h5>
            <hr>
        </div>
        <div class="menu-lateral">
            <a href="painel.php"><button>Painel</button></a>
            <a href="mascaras_pff_n95.php"><button>Máscara PFF/N95</button></a>
            <a href="documentos.php"><button>Documentos</button></a>
            <a href="blog.php"><button>Blog</button></a>
            <a href="relatorios.php"><button>Relatórios</button></a>
            <a href="perfil.php"><button>Perfil</button></a>
            <!-- <a href="senha.php"><button>Senha</button></a> -->
            <a href="suporte.php"><button>Suporte</button></a>
        </div>

    </div>
    <!-- Seu conteúdo vai aqui -->

    <!-- JavaScript -->
    <script src="../js/script.js"></script>
</body>
</html>