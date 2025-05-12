const forms = document.querySelectorAll("form");

forms.forEach(form => {
    form.addEventListener("submit", function (e) {
    if (!form.checkValidity()) {
        e.preventDefault();
    }
    form.classList.add("was-validated"); 
    });
});