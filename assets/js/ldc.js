document.addEventListener("DOMContentLoaded", function() {
    const frm = document.querySelector("form#list");
    const cbs = document.querySelectorAll("input[type='checkbox']");
    for (const cb of cbs) {
        cb.addEventListener("change", e => {
           frm.submit();
        });
    }
    document.querySelector("input[name='add']").focus();
});