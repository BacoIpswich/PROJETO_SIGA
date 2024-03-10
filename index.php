<?php
session_start(); // Inicia a sessão

if (isset($_SESSION['mensagem'])) {
    echo '<script>alert("' . $_SESSION['mensagem'] . '");</script>';
    unset($_SESSION['mensagem']); // Limpa a mensagem de sucesso da sessão
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <!-- Titulo -->
    <title>SIGA | Login</title>

    <!-- Inclua o seu arquivo CSS local aqui -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container"> <!-- Início do container -->

        <header>
            <a href="page/painel.php">
            <img src="doc/CAPA_FIOCRUZ.png" alt="Capa ini" class="responsive-img">
            </a>
        </header>

        <div> <!-- Início do div para o título -->
            <hr>
                <h1>Sistema Intranet de Gerenciamento Almoxarife <br> Login</h1>
            <hr>
        </div> <!-- Fim do div para o título -->

        <div> <!-- Início do div para a imagem de configuração -->
            <img src="doc/bt_configuração.bmp" alt="Configuração">
        </div> <!-- Fim do div para a imagem de configuração -->

        <form action="php/login.php" method="POST"> <!-- Início do formulário -->
            <div class="form-group"> <!-- Início do div para o campo CPF -->
                <input type="text" placeholder="CPF" id="cpf" name="cpf" oninput="formatarCPF(this);" onblur="validarCPF(this)" maxlength="14" required="">
            </div> <!-- Fim do div para o campo CPF -->

            <p id="mensagemErroCPF" class="regraVermelha"></p>

            <div class="form-group"> <!-- Início do div para o campo Senha -->
                <input type="password" placeholder="Senha" id="senha" name="senha" oninput="validarSenha(this); validarSenhas();" required="">
            </div> <!-- Fim do div para o campo Senha -->

            <div class="form-group"> <!-- Início do div para o botão Logar -->
    <input type="submit" value="Logar">
    <p id="mensagemErroLogin" class="regraVermelha"></p> <!-- Nova linha para a mensagem de erro do login -->
</div> <!-- Fim do div para o botão Logar -->


            <?php if (isset($_SESSION['erro'])): ?>
                <p class="regraVermelha"><?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?></p>
            <?php endif; ?>
        </form> <!-- Fim do formulário -->

        <div> <!-- Início do div para os links Esqueci a senha e Cadastro -->
            <br>
            <hr>
            <a href="page/recuperacao_senha.html">Esqueci a senha</a><br>
            <a href="page/cadastro.html">Cadastro</a>
        </div> <!-- Fim do div para os links Esqueci a senha e Cadastro -->
    </div> <!-- Fim do container -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Seu JavaScript -->
    <script src="js/script.js"></script>
    <script src="js/cpf.js"></script>
    <script src="js/senha.js"></script>
</body>
</html>