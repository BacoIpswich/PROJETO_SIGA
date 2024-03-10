<script>
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const erro = urlParams.get('erro');
    if (erro) {
        alert(erro);
    }
}
</script>
