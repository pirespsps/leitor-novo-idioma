function mostrarPopUp(palavra) {
    palavra = palavra.trim();
    palavra = palavra.slice()[0].toUpperCase() + palavra.substring(1);
    document.getElementById("palavra").innerText = palavra;
    document.getElementById("popupPalavra").hidden = false;

}

function fecharPopUp() {
    document.getElementById("significado").value = "";
    document.getElementById("popupPalavra").hidden = true;
}

export{mostrarPopUp,fecharPopUp}