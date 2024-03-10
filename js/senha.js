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
    
    // // Habilita o botão Salvar se todas as regras forem cumpridas
    // var regras = document.querySelectorAll('.regraVermelha');
    // var botaoSalvar = document.getElementById('botaoSalvar');
    // if (regras.length === 0) {
    //     botaoSalvar.disabled = false;
    // } else {
    //     botaoSalvar.disabled = true;
    // }
    
} // FINAL FUNCTION validarRegrasSenha