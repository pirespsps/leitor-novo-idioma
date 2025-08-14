import './bootstrap';
import axios from 'axios';

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

window.onbeforeunload = salvarPagina;

var pagina;
var paginasTotais;

document.addEventListener("DOMContentLoaded", () => { 
    pagina = parseInt(document.getElementById("paginaAtual").innerText) - 1;
    paginasTotais = document.getElementById("paginasTotais").innerHTML;
    mudarTexto(pagina);
});
checkPagina();

function mudarTexto(pagina) {

    let textoDiv = document.getElementById("textoDoc");
    textoDiv.innerHTML = "<div class='loader'></div>";

    axios.post("/documento/ler", {
        pagina: pagina
    })
        .then(
            response => {
                textoDiv = document.getElementById("textoDoc");
                textoDiv.innerHTML = "";

                const linhas = Object.values(response.data.linhas);
                const palavras = response.data.palavras;

                console.log(palavras);

                linhas.forEach(linha => {
                    textoDiv.appendChild(dividirLinha(linha,palavras));
                });

                document.getElementById("paginaAtual").innerHTML = response.data.pagina
                checkPagina();
            })
        .catch(
            error => console.log(error)
        )
}

function dividirLinha(linha,palavras) {

    let novaLinha = document.createElement("pre");
    novaLinha.classList = "container";
    const re = /[^A-Za-zÀ-ÿ-']/;

    linha.forEach(palavra => {

        const espaco = document.createElement("span");
        espaco.textContent = "";

        if(palavra == " "){
            novaLinha.appendChild(espaco);
        }

        if (palavra.search(re) == -1) {

            let palavraDiv = document.createElement("span");
            palavraDiv.textContent = palavra.trim();
            palavraDiv.style.cursor = "pointer"

            adicionarEventListener(palavraDiv,palavras);

            novaLinha.appendChild(palavraDiv);

        }else{
            //arrumar para quando o char estiver no meio da palavra.. (d'être, aujourd'hui...)

            const strEspecial = palavra.charAt(palavra.search(re));
            const charEspecial = document.createElement("span");
            charEspecial.textContent = strEspecial;

            const palavraDiv = document.createElement("span");
            palavraDiv.textContent = palavra.replace(strEspecial,"");
            palavraDiv.style.cursor = "pointer"

            adicionarEventListener(palavraDiv,palavras);

            if(palavra.indexOf(charEspecial.textContent) == 0){

                novaLinha.appendChild(charEspecial);
                novaLinha.appendChild(palavraDiv);
                novaLinha.appendChild(espaco);

            }else{
                novaLinha.appendChild(palavraDiv);
                novaLinha.appendChild(charEspecial);
            }
        }
    })

    return novaLinha;
}

function adicionarEventListener(palavra,palavras) {

    if (palavra.textContent != "" && palavra.textContent != null && palavra.textContent != " ") {

        const search = isPalavraConhecida(palavra.textContent,palavras);

            if(search === false){
                palavra.addEventListener("mouseover", e => {
                e.target.style.backgroundColor = "#8093fd";
            });

            palavra.addEventListener("mouseout", e => {
                e.target.style.backgroundColor = "white";
            });

            palavra.addEventListener("click", e => {
                let palavra = e.target.textContent.replace(/[^A-Za-zÀ-ÿ-']/,"");
                abrirDicionario(palavra);
                mostrarPopUp(palavra);
            });
        }else{
            palavra.style.backgroundColor = "rgba(128,147,253,0.3)";
            palavra.style.borderRadius = "3px";
            palavra.title = search;
            palavra.classList.add("significado");
        }
    }
}

function isPalavraConhecida(palavra, palavras){

    if(palavra in palavras){
        return palavras[palavra];
    }else{
        return false;
    }

}

function checkPagina() {

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
    mudarTexto(pagina);
}

function paginaAnterior() {
    pagina--;
    mudarTexto(pagina);

}

function desabilitarBotao(botao) {
    botao.style.opacity = "0.5";
    botao.disabled = true;
}

function habilitarBotao(botao) {
    botao.style.opacity = "1";
    botao.disabled = false;
}

function abrirDicionario(palavra) {
    let lar_janela = window.innerWidth;
    let alt_janela = window.innerHeight;
    palavra = palavra.trim();
    window.open(`http://frenchdictionary.com/translate/${palavra}`, "_blank", "toolbar=false, scrollbars=false,resizable=true, top=" + (-alt_janela) + ", left=" + (-lar_janela) + ", width=570, height=600");

}

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
