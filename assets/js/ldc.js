console.log("%c LDC\t", "background: red");

document.addEventListener("DOMContentLoaded", function() {
    const frm = document.querySelector("form#list");
    const cbs = document.querySelectorAll("input[type='checkbox']");
    const listItems = document.querySelectorAll("tbody td");
    const btDel = document.querySelector("#btDel");

    for (const cb of cbs) {
        cb.addEventListener("change", e => {
           frm.submit();
        });
    }

    btDel.addEventListener("click", function(e) {
        this.setAttribute("type", "submit");
        console.log(this);
        this.removeAttribute('type');
    });

    document.querySelector("input[name='add']").focus();
});