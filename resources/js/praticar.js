import axios from 'axios';

let palavraAtual = document.getElementById("perguntaAtual").innerText;
const palavrasArray = [];
const respostas = [];

const PALAVRA = 0;

document.getElementsByName(`palavras[]`).forEach(element =>{
    element.classList.remove("d-none");
});

document.getElementsByName("palavras[]").forEach(element => {
    let valor = element.value;
    palavrasArray.push(valor.split("|"));
});

document.getElementById("confirmBT").addEventListener("click", () => {
    trocarPalavra();
});

function trocarPalavra() {

    if(isInputNull()){
        //
    }else{
        if(isFinalizado()){
            enviarForm();
        }else{
            salvarResposta();
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
    if (palavraAtual == palavrasArray.length) {
        return true;
    } else {
        return false;
    }
}

function enviarForm() {
    axios.post("praticar/resultado",{
        palavras: palavrasArray,
        respostas: respostas 
    }).then(
        response => console.log(response.data)//window.location.href = response.data
    ).catch(
        error => console.log(error)
    );
}

function salvarResposta() {
    let resposta = document.getElementById("resposta").value.trim();
    respostas.push(resposta);
    limparInput();
}

function limparInput() {
    document.getElementById("resposta").value = "";
}

function isInputNull() {
    if (document.getElementById("resposta").value.trim() == "") {
        return true;
    } else {
        return false;
    }
}