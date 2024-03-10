<?php
// Inicia a sessão
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGA | Confirmação de Dados</title>

    <!-- Inclua o seu arquivo CSS local aqui -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
    <div class="container"> 
        <header> 
            <a href="painel.html">
            <img src="../doc/CAPA_FIOCRUZ.png" alt="Capa ini" class="responsive-img">
            </a>
        </header>
        <div> 
            <hr>
                <h1>Sistema Intranet de Gerenciamento Almoxarife <br> Confirmação de Dados</h1>
            <hr>
        </div> 
        <div> 
            <img src="../doc/bt_relatorio_02.bmp" alt="Buscar">
        </div> 
        <div> 
            <p>Por favor, confirme seus dados:</p>
            <form id="confirmacaoDadosForm" action="../php/redefinir_senha.php" method="post">
                <div class="form-group">
                    <input type="text" id="nome" name="nome" value="<?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : ''; ?>" readonly style="border: none;"><br>
                    <input type="text" id="cpf" name="cpf" value="<?php echo isset($_SESSION['cpf']) ? $_SESSION['cpf'] : ''; ?>" readonly style="border: none;"><br>
                    <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" readonly style="border: none;"><br>
                </div>
                <div class="form-group">
                    <input type="submit" value="Alterar Senha">
                </div>
            </form>
        </div>
                
        <br><br>
        <hr>
           <a href="../index.php">Voltar</a> 
    </div> 
    <script src="../js/script.js"></script>
    <script src="../js/cpf.js"></script>
    
</body>
</html>
