document.addEventListener("DOMContentLoaded", function() {
    var inputPassword = document.getElementById("input-pwd");
    var eyeIcon = document.getElementById("eye-img-match");

    eyeIcon.addEventListener("click", function() {
        if (inputPassword.type === "password") {
            inputPassword.type = "text";
            eyeIcon.src = "public/img/eye-slash-fill.svg";
            eyeIcon.alt = "Ocultar contraseña";
        } else {
            inputPassword.type = "password";
            eyeIcon.src = "public/img/eye-fill.svg";
            eyeIcon.alt = "Mostrar contraseña";
        }
    });
});