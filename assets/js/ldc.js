const frm = document.querySelector("form#list");
const cbs = document.querySelectorAll("input[type='checkbox'].crossout");

for (const cb of cbs) {
    cb.addEventListener("change", e => {
        vf = frm.dispatchEvent(new Event("submit"));
    });

}