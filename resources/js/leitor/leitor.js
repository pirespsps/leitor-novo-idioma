import '../bootstrap.js';
import axios from 'axios';
import { mudarTexto } from './modules/texto.js';
import { fecharPopUp } from "./modules/popup.js";

var pagina;
var paginasTotais;

document.getElementById("paginaAnterior").addEventListener("click", paginaAnterior);
document.getElementById("paginaPosterior").addEventListener("click", paginaPosterior);
document.getElementById("cancelarPopup").addEventListener("click", fecharPopUp);
document.getElementById("confirmarPopup").addEventListener("click", ()=>{

    const palavra = document.getElementById("palavra").innerText.trim().toLowerCase();
    const significado = document.getElementById("significado").value.trim().toLowerCase();

    if(significado != ""){
        salvarPalavra(palavra,significado);
        fecharPopUp();
    }
});

document.addEventListener("DOMContentLoaded", () => { 
    pagina = parseInt(document.getElementById("paginaAtual").innerText) - 1;
    paginasTotais = document.getElementById("paginasTotais").innerHTML;
    mudarTexto(pagina,paginasTotais,checkPagina);
});

checkPagina(pagina,paginasTotais);
window.onbeforeunload = salvarPagina;


function checkPagina(pagina,paginasTotais) {

    let botaoPos = document.getElementById("paginaPosterior");
    let botaoAnt = document.getElementById("paginaAnterior");

    if (pagina == paginasTotais - 1) {
        desabilitarBotao(botaoPos);
    } else if (pagina == 0) {
        desabilitarBotao(botaoAnt);
    } else if (botaoAnt.disabled && pagina > 0) {
        habilitarBotao(botaoAnt);
    } else if (botaoPos.disabled && pagina != paginasTotais - 1) {
        habilitarBotao(botaoPos);
    }
}

function salvarPagina() {
    axios.post("/documento/salvarPagina", {}).then(response => console.log(response))
        .catch(
            error => console.log(error)
        );
}

function paginaPosterior() {
    pagina++;
    mudarTexto(pagina,paginasTotais,checkPagina);
}

function paginaAnterior() {
    pagina--;
    mudarTexto(pagina,paginasTotais,checkPagina);

}

function desabilitarBotao(botao) {
    botao.style.opacity = "0.5";
    botao.disabled = true;
}

function habilitarBotao(botao) {
    botao.style.opacity = "1";
    botao.disabled = false;
}

//mudar no dom
function salvarPalavra(palavra, significado) {

    const token = document.querySelector('meta[name="token"]').content;
    const headers = {
        'X-CSRF-Token': token
    }
    const rota = document.querySelector('meta[name="rota"]').content;

    axios.post(rota, {
        palavra: palavra,
        significado: significado
    },{
        headers: headers        
    }).then(
        response => {
            console.log(response.data)
            window.location.reload();
        }
    ).catch(
        error => console.log(error)
    );
}
