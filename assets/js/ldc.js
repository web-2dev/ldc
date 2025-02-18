console.log("%c LDC\t", "background: red");
let add;
document.addEventListener("DOMContentLoaded", function() {
    const frm = document.querySelector("form#list");
    const cbs = document.querySelectorAll("input[type='checkbox']");
    const itemList = document.querySelectorAll("tbody td");
    const editInputs = document.querySelectorAll("input.edit");
    const btDel = document.querySelector("#btDel");

    // Cases à cocher : rayer l'article
    for (const cb of cbs) {
        cb.addEventListener("change", e => {
           frm.submit();
        });
    }

    // Bouton effacer les articles rayés
    btDel.addEventListener("click", function(e) {
        this.setAttribute("type", "submit");
        this.removeAttribute('type');
    });

    // modifier les articles
    itemList.forEach(td => {
        td.addEventListener("click", function(event) {
            let input = td.querySelector("input");
            let id = input.id.replace("input", "");
            let cb = document.querySelector("[name='"+ id + "']");
            if( cb && cb.checked || !input.classList.contains("hide") ) {

            } else {
                input.classList.remove("hide");
                input.focus();
                input.select();
            }

        })
    });

    editInputs.forEach(function(editInput) {
        editInput.addEventListener("focusout", e => { 
            const input = e.target;
            input.classList.add("hide");
            let oldValue = input.parentElement.querySelector("span").innerHTML;
            let newValue = input.value;
            input.parentElement.querySelector("span").innerHTML = input.value;
            if(oldValue != newValue) frm.submit();
        });
    });

    document.querySelector("input[name='add']").focus();
});