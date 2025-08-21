export function abrirDicionario(palavra, idioma) {
    console.log(idioma);
    let lar_janela = window.innerWidth;
    let alt_janela = window.innerHeight;
    let dicionario = getLinkDicionario(idioma);
    palavra = palavra.trim(); //trocar para quando tiver char especial
    window.open(`${dicionario}${palavra}`, "_blank", "toolbar=false, scrollbars=false,resizable=true, top=" + (-alt_janela) + ", left=" + (-lar_janela) + ", width=570, height=600");
}

export function isPalavraConhecida(palavra, palavras){

    if(palavra in palavras){
        return palavras[palavra];
    }else{
        return false;
    }
}

function getLinkDicionario(idioma){
    //mudar para API 
    let dicionarios = {
        "en" : "https://www.oed.com/search/dictionary/?scope=Entries&q=",
        "fr" : "http://frenchdictionary.com/translate/",
        "pt" : "https://www.dicio.com.br/",
        "es" : "https://www.spanishdict.com/translate/",
        'it' : "https://www.dizionario-italiano.it/dizionario-italiano.php?parola="
    };

    return dicionarios[idioma];
}