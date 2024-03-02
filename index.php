<?php
session_start(); // Inicia a sessão

if (isset($_SESSION['erro'])) {
    echo '<script>alert("' . $_SESSION['erro'] . '");</script>';
    unset($_SESSION['erro']); // Limpa a mensagem de erro da sessão
}

// Seu código HTML aqui...
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
    <div class="container">
        <header>
            <a href="page/painel.php">
            <img src="doc/CAPA_FIOCRUZ.png" alt="Capa ini" class="responsive-img">
            </a>
        </header>
        <div>
            <hr>
                <h1>Sistema Intranet de Gerenciamento Almoxarife <br> Login</h1>
            <hr>
        </div>
        <div>
            <img src="doc/bt_configuração.bmp" alt="Configuração">
        </div>

        <form action="php/login.php" method="POST">
        <div class="form-group">
            <input type="text" placeholder="CPF" id="cpf" name="cpf" onkeyup="formatarCPF(this);" onblur="validarCPF(this)" maxlength="14" required="">
        </div>

        <p id="mensagemErroCPF" class="regraVermelha"></p>

        <div class="form-group">
            <input type="password" placeholder="Senha" id="senha" name="senha" oninput="validarSenha(this); validarSenhas();" required="">
            <p id="mensagemErroSenha" class="regraVermelha"></p>
        </div>
        <div class="form-group">
            <input type="submit" value="Logar">
        </div>
        <?php if (isset($_SESSION['erro'])): ?>
    <p class="regraVermelha"><?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?></p>
<?php endif; ?>

    </form>
        <div>
            <br>
            <hr>
            <a href="page/recuperacao_senha.html">Esqueci a senha</a><br>
            <a href="page/cadastro.html">Cadastro</a>
        </div>
    </div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Seu JavaScript -->
<script src="js/script.js"></script>
</body>
</html>
