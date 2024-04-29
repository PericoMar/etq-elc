const userOpt = document.getElementById("user-opt");
const productOpt = document.getElementById("product-opt");
const baseUrl = "/etq-elc";

userOpt.addEventListener("click", () => {
    window.location.href = baseUrl+'/gestion-usuarios/';
});

productOpt.addEventListener("click" , () => {
    window.location.href = baseUrl+'/gestion-productos/';
});