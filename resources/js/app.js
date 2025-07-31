import './bootstrap';
import axios from 'axios';

document.querySelectorAll(".rmvBotao").forEach(element => element.addEventListener("click",(e)=>{
    removerDocumento(element);}
));

function removerDocumento(botao){
    console.log(botao.value);
    axios.post("/biblioteca/remover",{
        id : botao.value
    }).then(
        response => {
            console.log(response)
            let divParent = botao.parentElement;
            divParent.style.display = "none";
        }
    ).catch(
        error => console.log(error)
    );
}