/********************************************************************************************************************/
/* Validamos el formulario de login para comprobar que tanto el mail como la contraseña, tienen el formato correcto */
/********************************************************************************************************************/
let email;
let password;
let totalErrors;
let errorEmail;
let errorPassword;

//Recuperamos el valor de los campos del formulario
let loginForm = document.getElementById("loginForm");

//Mostrar/ocultar contraseña
function showHidePassword() {
    let psw = document.getElementById("userPassword");
    let eyeIcon = document.getElementById("eyeIcon");
  
    if (psw.type == "password") {
        eyeIcon.classList.remove("fa-eye")
        eyeIcon.classList.add("fa-eye-slash");
        psw.type = "text";
    } else if(psw.type == "text") {
        eyeIcon.classList.remove("fa-eye-slash")
        eyeIcon.classList.add("fa-eye");
        psw.type = "password";
    }
}

function login(){
    //Inicializamos los errores
    totalErrors = 0;

    validateEmail();

    validatePassword();

    if (totalErrors > 0) {
        return false;
    } else {
        loginForm.action="../php/login.php";
    }
}
 
//Recupararmos el campo de email y lo validamos
function validateEmail() {
   email = document.getElementById("userEmail");
   errorEmail = document.getElementById("errorEmail");

   if (email.value == "") {
        email.classList.add("is-invalid");
        errorEmail.textContent = "Por favor, escribe tu email";
        totalErrors++;
    } else if (!validateFormatEmail(email.value)) {
        email.classList.add("is-invalid");
        errorEmail.textContent = "El formato del email no es correcto. Ej. email@gmail.com";
        totalErrors++;
    }  
}

//Comprueba que el campo email tiene un formato correcto antes de enviar la petición al servidor
function validateFormatEmail(email) {
    const regexEmail = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regexEmail.test(email) ? true : false;
}
 
function validatePassword(){
    password = document.getElementById("userPassword");
    errorPassword = document.getElementById("errorPassword");
    if (password.value == "") {
        password.classList.add("is-invalid");
        errorPassword.textContent = "Por favor, escribe tu constraseña";
        totalErrors++;
    } else if (!validateFormatPassword(password.value)) {
        password.classList.add("is-invalid");
        errorPassword.textContent = "El formato de la contraseña no es correcto.";
        totalErrors++;
    }  

}

//Comprueba que el campo contrañsa tenga un formato correcto antes de enviar la petición al servidor
//(Mínimo 8 caracteres, máximo 15, mínimo 1 mayúscula, mínimo 1 minúscula, mínimo 1 número, no espacios)
function validateFormatPassword(password) {
    const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8}$/;
    return regexPassword.test(password) ? true : false;
}

 
//Si el formulario existe, al retirar el foco quitaremos la clase "is-invalid".
if (loginForm) {
    loginForm.addEventListener("blur", (event) => {
        if (event.target.value != "") event.target.classList.remove("is-invalid");
    }, true);

}


 