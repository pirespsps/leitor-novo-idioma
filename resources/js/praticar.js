import axios from 'axios';

let palavraAtual = document.getElementById("perguntaAtual").innerText;
const palavrasArray = [];
const respostas = [];

const PALAVRA = 0;

document.getElementsByName("palavras[]").forEach(element => {
    let valor = element.value;
    palavrasArray.push(valor.split("|"));
});

document.getElementById("confirmBT").addEventListener("click", () => {
    trocarPalavra();
});

function trocarPalavra() {

    if (isFinalizado) {
        enviarForm();
    } else {
        if (salvarResposta()) {
            trocarNumeroPergunta();
            document.getElementById("palavra").textContent = palavrasArray[palavraAtual - 1][PALAVRA];
        }
    }
}

function trocarNumeroPergunta() {
    palavraAtual++;
    document.getElementById("perguntaAtual").innerText = palavraAtual;
}

function isFinalizado() {
    if (palavraAtual - 1 === palavrasArray.length) {
        return true;
    } else {
        return false;
    }
}

function enviarForm() {

}

function salvarResposta() {
    let resposta = document.getElementById("resposta").value.trim();
    if (resposta == "") {
        return false;
    } else {
        respostas.push(resposta);
        limparInput();
        return true;
    }
}

function limparInput() {
    document.getElementById("resposta").value = "";
}