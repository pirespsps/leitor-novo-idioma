import {isPalavraConhecida,abrirDicionario} from "./dicionario.js";
import {mostrarPopUp} from "./popup.js";

export function mudarTexto(pagina,paginasTotais,checkPagina) {

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
                const idioma = response.data.idioma;
                console.log("idioma = " + idioma );

                linhas.forEach(linha => {
                    textoDiv.appendChild(dividirLinha(linha,palavras,idioma));
                });

                document.getElementById("paginaAtual").innerHTML = response.data.pagina
                checkPagina(pagina,paginasTotais);
            })
        .catch(
            error => console.log(error)
        )
}

function dividirLinha(linha,palavras,idioma) {

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

            adicionarEventListener(palavraDiv,palavras,idioma);

            novaLinha.appendChild(palavraDiv);

        }else{
            //arrumar para quando o char estiver no meio da palavra.. (d'être, aujourd'hui...)
            //separar em função

            const strEspecial = palavra.charAt(palavra.search(re));
            const charEspecial = document.createElement("span");
            charEspecial.textContent = strEspecial;

            const palavraDiv = document.createElement("span");
            palavraDiv.textContent = palavra.replace(strEspecial,"");
            palavraDiv.style.cursor = "pointer"

            adicionarEventListener(palavraDiv,palavras,idioma);

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

function adicionarEventListener(palavra,palavras,idioma) {

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
                abrirDicionario(palavra,idioma);
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