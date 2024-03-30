function formatarCPF(el) {
    var cpf = el.value;
    cpf = cpf.replace(/\D/g, ""); 
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); 
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); 
    cpf = cpf.replace(/(\d{3})(\d{2})$/, "$1-$2"); 
    el.value = cpf;
}

function validarCPF(el) {
    var strCPF = cpf.replace(/[.-]/g, ""); 
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
