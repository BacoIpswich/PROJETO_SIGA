function formatarCPF(el) {
    var cpf = el.value;
    cpf = cpf.replace(/\D/g, ""); // Remove tudo o que não é dígito
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // Coloca um ponto entre o terceiro e o quarto dígitos
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // Coloca um ponto entre o terceiro e o quarto dígitos de novo (para o segundo bloco de números)
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // Coloca um hífen entre o terceiro e o quarto dígitos
    el.value = cpf;
}

function validarCPF(el) {
    var strCPF = el.value.replace(/[.-]/g, ""); // Remove os pontos e traços
    var Soma;
    var Resto;
    Soma = 0;
    if (strCPF == "00000000000") {
        document.getElementById('mensagemErroCPF').textContent = 'CPF Inválido';
        return false;
    }
    for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) {
        document.getElementById('mensagemErroCPF').textContent = 'CPF Inválido';
        return false;
    }
    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) {
        document.getElementById('mensagemErroCPF').textContent = 'CPF Inválido';
        return false;
    }
    document.getElementById('mensagemErroCPF').textContent = '';
    return true;
}

function validarSenha(el) {
    var senha = el.value;
    var mensagemErroSenha = document.getElementById('mensagemErroSenha');

    if (senha.length === 0) {
        mensagemErroSenha.textContent = 'Por favor, preencha a senha.';
        return false;
    }

    // Se a senha passar na verificação, limpa a mensagem de erro
    mensagemErroSenha.textContent = '';
    return true;
}

function validarSenhaCadastro() {
    var senha = document.getElementById('senha').value;
    var confirmaSenha = document.getElementById('confirmaSenha').value;
}
    function validarSenhaCadastro() {
        var senha = document.getElementById('senha').value;
        var confirmaSenha = document.getElementById('confirmaSenha').value;
        var botaoSalvar = document.getElementById('botaoSalvar');
    
        // Verifica o comprimento da senha
        if (senha.length < 6) {
            document.getElementById('regraTamanho').classList.add('regraVermelha');
        } else {
            document.getElementById('regraTamanho').classList.remove('regraVermelha');
        }
    
        // Verifica a presença de uma letra maiúscula
        if (!/[a-zA-Z]/.test(senha)) {
            document.getElementById('regraMaiuscula').classList.add('regraVermelha');
        } else {
            document.getElementById('regraMaiuscula').classList.remove('regraVermelha');
        }
        
        // Verifica a presença de um caractere especial
        if (!/[!@#$%^&*]/.test(senha)) {
            document.getElementById('regraEspecial').classList.add('regraVermelha');
        } else {
            document.getElementById('regraEspecial').classList.remove('regraVermelha');
        }
    
        // Verifica a presença de um número
        if (!/[0-9]/.test(senha)) {
            document.getElementById('regraNumero').classList.add('regraVermelha');
        } else {
            document.getElementById('regraNumero').classList.remove('regraVermelha');
        }
    
        // Verifica se as senhas são iguais
        if (senha !== confirmaSenha) {
            document.getElementById('regraIgual').classList.add('regraVermelha');
        } else {
            document.getElementById('regraIgual').classList.remove('regraVermelha');
        }
    
        // Habilita o botão Salvar se todas as regras forem cumpridas
        var regras = document.querySelectorAll('.regraVermelha');
        if (regras.length === 0) {
            botaoSalvar.disabled = false;
        } else {
            botaoSalvar.disabled = true;
        }
    }

 // Obtém os parâmetros da URL
 var urlParams = new URLSearchParams(window.location.search);

 // Verifica se o parâmetro de erro existe
 if (urlParams.has('erro')) {
     var erro = urlParams.get('erro');

     // Verifica o tipo de erro e exibe a mensagem de alerta correspondente
     if (erro === 'UsuarioJaExiste') {
         alert('Este usuário já existe!');
     }
     // Adicione mais condições aqui para outros tipos de erros
 }


 function recuperarSenha(event) {
    event.preventDefault(); // Isso impede que a página seja recarregada quando o formulário for enviado
  
    var cpf = document.getElementById("cpf").value;
  
    // Aqui você pode adicionar a lógica para verificar o CPF e enviar o e-mail
    // Por exemplo, você pode fazer uma solicitação AJAX ao seu servidor aqui
  
    // Vamos supor que o e-mail associado ao CPF é 'usuario@example.com'
    var email = 'usuario@example.com';
  
    // Mostra apenas a parte do e-mail antes do '@'
    var emailParcial = email.split('@')[0].slice(0,3) + '***@' + email.split('@')[1];
  
    alert("Um e-mail foi enviado para o endereço de e-mail associado ao CPF: " + cpf + ". Verifique sua caixa de entrada em " + emailParcial);
  }
  
  // Adicione um ouvinte de evento ao formulário para chamar a função recuperarSenha quando o formulário for enviado
  document.getElementById("recuperacaoSenhaForm").addEventListener("submit", recuperarSenha);