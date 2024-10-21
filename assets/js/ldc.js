console.log("%Chargement du JS");

const frm = document.querySelector("form#list");
const cbs = document.querySelectorAll("input[type='checkbox']");

for (const cb of cbs) {
    cb.addEventListener("change", e => {
        frm.submit();
    });

}


document.querySelectorAll("input[type='text']").forEach( (element, index) => {
    element.addEventListener("keydown", e => {
        if(e.key == "Enter"){
            e.preventDefault();
            document.querySelector("#btSubmit").click();
        }
    })
})