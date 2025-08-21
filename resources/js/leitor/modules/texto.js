import { isPalavraConhecida, abrirDicionario } from "./dicionario.js";
import { mostrarPopUp } from "./popup.js";

let palavras;
let idioma;

export function mudarTexto(pagina, paginasTotais, checkPagina) {

    let textoDiv = document.getElementById("textoDoc");
    textoDiv.innerHTML = "<div class='loader'></div>";

    textoDiv.addEventListener("click", e => {

    if (e.target.classList.contains('palavraDesconhecida') && e.target.tagName == 'SPAN') {
        let palavra = e.target.textContent.replace(/[^A-Za-zÀ-ÿ-']/, "");
        abrirDicionario(palavra, idioma);
        mostrarPopUp(palavra);
    }
    
});

    axios.post("/documento/ler", {
        pagina: pagina
    })
        .then(
            response => {
                textoDiv.innerHTML = "";

                const linhas = Object.values(response.data.linhas);
                palavras = response.data.palavras; //palavras conhecidas
                idioma = response.data.idioma;

                let fragment = document.createElement("div");
                linhas.forEach(linha => {
                    fragment.appendChild(dividirLinha(linha));
                });
                textoDiv.appendChild(fragment);

                document.getElementById("paginaAtual").innerHTML = response.data.pagina
                checkPagina(pagina, paginasTotais);
            })
        .catch(
            error => console.log(error)
        )
}

function dividirLinha(linha) {

    let novaLinha = document.createElement("pre");
    novaLinha.classList = "container";
    let re = /^[^A-Za-zÀ-ÿ']|[^A-Za-zÀ-ÿ']$/;

    linha.forEach(palavra => {

        const espaco = document.createElement("span");
        espaco.textContent = "";

        if (palavra == " ") {
            novaLinha.appendChild(espaco);
        }

        if (palavra.search(re) == -1) {
            novaLinha = insertPalavraSemSpecial(palavra,novaLinha);

        } else {
            novaLinha = insertPalavraSpecial(palavra,re,novaLinha);
        }
    })

    return novaLinha;
}

function adicionarEventListener(palavra, palavras) {

    if (palavra.textContent != "" && palavra.textContent != null && palavra.textContent != " ") {

        const search = isPalavraConhecida(palavra.textContent, palavras);

        if (search === false) {
            palavra.classList.add("palavraDesconhecida");
        } else {
            palavra.style.backgroundColor = "rgba(128,147,253,0.3)";
            palavra.style.borderRadius = "3px";
            palavra.title = search;
            palavra.classList.add("significado");
        }
    }
}

function insertPalavraSemSpecial(palavra,linha) {
    let palavraDiv = document.createElement("span");
    palavraDiv.classList.add("palavra");
    palavraDiv.textContent = palavra.trim();

    adicionarEventListener(palavraDiv, palavras, idioma);

    linha.appendChild(palavraDiv);
    return linha;
}

function insertPalavraSpecial(palavra,re,linha) {

    const strEspecial = palavra.charAt(palavra.search(re));
    const charEspecial = document.createElement("span");
    const espaco = document.createElement("span");
    charEspecial.textContent = strEspecial;

    const palavraDiv = document.createElement("span");
    palavraDiv.textContent = palavra.replace(strEspecial, "");
    palavraDiv.style.cursor = "pointer"

    adicionarEventListener(palavraDiv, palavras, idioma);

    if (palavra.indexOf(charEspecial.textContent) == 0) {

        linha.appendChild(charEspecial);
        linha.appendChild(palavraDiv);
        linha.appendChild(espaco);

    } else {
        linha.appendChild(palavraDiv);
        linha.appendChild(charEspecial);
    }

    return linha;
}