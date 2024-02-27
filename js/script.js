// Função para verificar os dados de login
function verificarLogin() {
  // Pega os valores dos campos do formulário de login
  var cpf = document.getElementById('cpf').value;
  var senha = document.getElementById('senha').value;

  // Obtém a string JSON do LocalStorage
  var json = localStorage.getItem('CadastroDeLogin');

  // Converte a string JSON em um objeto
  var data = JSON.parse(json);

  // Verifica se os dados de login correspondem aos dados armazenados
  if (cpf === data.cpf && senha === data.senha) {
    // Redireciona para outra página
    window.location.href = "../index.html";
  } else {
    // Mostra um alerta
    alert('CPF ou senha incorretos.');
  }

  // Limpa os campos do formulário
  document.getElementById('cpf').value = "";
  document.getElementById('senha').value = "";
}

// Adiciona um evento de submit ao formulário de login
document.querySelector('form').addEventListener('submit', function(event) {
  // Previne o comportamento padrão do formulário
  event.preventDefault();

  // Verifica os dados de login
  verificarLogin();
});
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

            // Verifica o comprimento da senha
            if (senha.length < 6) {
                mensagemErroSenha.textContent = 'A senha deve ter pelo menos 6 caracteres.';
                return false;
            }

            // Verifica se a senha contém pelo menos uma letra
            if (!/[a-zA-Z]/.test(senha)) {
                mensagemErroSenha.textContent = 'A senha deve conter pelo menos uma letra.';
                return false;
            }

            // Verifica se a senha contém pelo menos um número
            if (!/[0-9]/.test(senha)) {
                mensagemErroSenha.textContent = 'A senha deve conter pelo menos um número.';
                return false;
            }

            // Verifica se a senha contém pelo menos um caractere especial
            if (!/[!@#$%^&*]/.test(senha)) {
                mensagemErroSenha.textContent = 'A senha deve conter pelo menos um caractere especial.';
                return false;
            }

            // Se a senha passar em todas as verificações, limpa a mensagem de erro
            mensagemErroSenha.textContent = '';
            return true;
        }
