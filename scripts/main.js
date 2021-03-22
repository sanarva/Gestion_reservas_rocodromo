/********************************************************************************************************************/
/* Validamos el formulario de login para comprobar que tanto el mail como la contraseña, tienen el formato correcto */
/********************************************************************************************************************/
//Declaramos las variables globales
let totalErrors;
let errorConfirmNewPassword;
let userConfirmNewPassword;

//Variable necesaria para determinar si existe o no formulario de login 
let loginForm = document.getElementById("loginForm");

//Variable necesaria para determinar si existe o no formulario de cambio de contraseña
let modifyPasswordForm = document.getElementById("modifyPasswordForm");

//Variable necesaria para determinar si existe o no formulario de zonas 
let zoneForm = document.getElementById("zoneForm");

//Variable necesaria para determinar si existe o no formulario de recuperar contraseña 
let recoveryPswForm = document.getElementById("recoveryPswForm");

//Variable necesaria para determinar si existe o no formulario de usuarios 
let userForm = document.getElementById("userForm");

//Mostrar/ocultar contraseña
function showHidePassword(field) {
    let psw = document.getElementById(field);
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


//Función usada para hacer las validaciones del formulario de login antes de hacer la petición al servidor
function login(){
    //Inicializamos los errores
    totalErrors = 0;
    //Validamos el formato del email 
    validateEmail();

    //Recuperamos el valor de la contraseña y validamos su formato
    let password = document.getElementById("userPassword");
    let errorPassword = document.getElementById("errorPassword");
    validatePassword(password, errorPassword);

    if (totalErrors > 0) {
        return false;
    } else {
        loginForm.action="../php/login.php";
    }
}


//Función usada para hacer las validaciones del formulario de cambio de contraseña antes de hacer la petición al servidor
function modifyPassword(){

    //Inicializamos los errores
    totalErrors = 0;

    //Validamos el formato del email 
    validateEmail();

    //Validamos el formato de la contraseña actual
    let userCurrentPassword = document.getElementById("userCurrentPassword");
    let errorCurrentPassword = document.getElementById("errorCurrentPassword");
    validatePassword(userCurrentPassword, errorCurrentPassword);
    
   //Validamos el formato de la nueva contraseña 
   let userNewPassword = document.getElementById("userNewPassword");
   let errorNewPassword = document.getElementById("errorNewPassword");
   validatePassword(userNewPassword, errorNewPassword);
    
    //Validamos que la contraseña nueva 1 coincida con la contraseña nueva 2 
    userConfirmNewPassword = document.getElementById("userConfirmNewPassword");
    errorConfirmNewPassword = document.getElementById("errorConfirmNewPassword");

    if (userNewPassword.value != userConfirmNewPassword.value){
        userConfirmNewPassword.classList.add("is-invalid");
        errorConfirmNewPassword.textContent = "La nueva contraseña no coincide";
        totalErrors++;
    }

    if (totalErrors > 0) {
        return false;
    } else {
        modifyPasswordForm.action="../php/password.php";
    }
}


//Recuperamos el campo de email y lo validamos
function validateEmail() {
   let email = document.getElementById("userEmail");
   let errorEmail = document.getElementById("errorEmail");

   if (email.value == "") {
        email.classList.add("is-invalid");
        errorEmail.textContent = "Por favor, escribe el email";
        totalErrors++;
    } else if (!validateFormatEmail(email.value)) {
        email.classList.add("is-invalid");
        errorEmail.textContent = "El formato del email no es correcto. Ej. email@gmail.com";
        totalErrors++;
    }  
}


//Comprueba que el campo email tiene un formato correcto antes de enviar la petición al servidor
function validateFormatEmail(email) {
    const regexEmail = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;    return regexEmail.test(email) ? true : false;
}
 

function validatePassword(password, errorPassword){
    if (password.value == "") {
        password.classList.add("is-invalid");
        errorPassword.textContent = "Por favor, escribe tu contraseña";
        totalErrors++;
    } else if (!validateFormatPassword(password.value)) {
        password.classList.add("is-invalid");
        errorPassword.textContent = "El formato de la contraseña no es correcto.";
        totalErrors++;
    }  
}

//Comprueba que el campo contraseña tenga un formato correcto antes de enviar la petición al servidor
//(8 caracteres, mínimo 1 mayúscula, mínimo 1 minúscula, mínimo 1 número, no espacios)
function validateFormatPassword(password) {
    const regexPassword = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8}$/;
    return regexPassword.test(password) ? true : false;
}


//Función usada para hacer las validaciones del formulario de zonas antes de hacer la petición al servidor
function validateZoneForm(btnClicked){
    //Inicializamos los errores
    totalErrors = 0;

    let action = document.getElementById(btnClicked).formAction;

    //Recuperamos el valor del nombre de la zona y validamos su formato
    let zoneName = document.getElementById("zoneName");
    let errorZoneName = document.getElementById("errorZoneName");
    if (zoneName.value == "") {
        zoneName.classList.add("is-invalid");
        errorZoneName.textContent = "Por favor, escribe el nombre de la zona (máx. 30 letras)";
        totalErrors++;
    }

    //Recuperamos el valor del número máximo de usuarios por zona y validamos su formato
    let maxUserNumber = document.getElementById("maxUserNumber");
    let errorMaxUserNumber = document.getElementById("errorMaxUserNumber");
    if (maxUserNumber.value == "") {
        maxUserNumber.classList.add("is-invalid");
        errorMaxUserNumber.textContent = "Por favor, escribe un número máximo de usuarios en la zona (de 1 a 99)";
        totalErrors++;
    }
    
    if (totalErrors > 0) {
        return false;
    } else {
        zoneForm.action = action;
    }
}
 

//Función usada para hacer las validaciones del formulario de recuperar contraseña antes de hacer la petición al servidor
function checkEmail(){
    //Inicializamos los errores
    totalErrors = 0;
    //Validamos el formato del email 
    validateEmail();

    if (totalErrors > 0) {
        return false;
    } else {
        recoveryPswForm.action="../php/sendNewPassword.php";
    }
}


//Función usada para hacer las validaciones del formulario de usuarios antes de hacer la petición al servidor
function validateUserForm(btnClicked){
    //Inicializamos los errores
    totalErrors = 0;

    let action = document.getElementById(btnClicked).formAction;

    //Recuperamos el valor del nombre del usuario y validamos su formato
    let userName = document.getElementById("inputUserName");
    let errorUserName = document.getElementById("errorUserName");
    if (userName.value == "") {
        userName.classList.add("is-invalid");
        errorUserName.textContent = "Por favor, escribe un nombre de usuario";
        totalErrors++;
    }

    //Recuperamos el número de tajeta y validamos que sea numérico entre 0 y 999999
    let cardNumber = document.getElementById("cardNumber");
    let errorCardNumber = document.getElementById("errorCardNumber");
    if (cardNumber.value == "") {
        cardNumber.classList.add("is-invalid");
        errorCardNumber.textContent = "Por favor, escribe el número de tarjeta";
        totalErrors++;
    } else if (isNaN(cardNumber.value)) {
        cardNumber.classList.add("is-invalid");
        errorCardNumber.textContent = "El número de tarjeta debe ser un número";
        totalErrors++;
    }
    
    //Validamos el formato del email 
    validateEmail();

    
    if (totalErrors > 0) {
        return false;
    } else {
        userForm.action = action;
    }
}



/////////////////////////////////////////////////////////////////////////////////////
//Si el formulario existe, al retirar el foco quitaremos la clase "is-invalid".    //
/////////////////////////////////////////////////////////////////////////////////////
if (loginForm) {
    loginForm.addEventListener("blur", (event) => {
        if (event.target.value != "") event.target.classList.remove("is-invalid");
    }, true);
}

if (modifyPasswordForm) {
    modifyPasswordForm.addEventListener("blur", (event) => {
        if (event.target.value != "") event.target.classList.remove("is-invalid");
    }, true);
}

if (zoneForm) {
    zoneForm.addEventListener("blur", (event) => {
        if (event.target.value != "") event.target.classList.remove("is-invalid");
    }, true);
}

if (userForm) {
    userForm.addEventListener("blur", (event) => {
        if (event.target.value != "") event.target.classList.remove("is-invalid");
    }, true);
}

//Ocultar error en formulario de recuperar contraseña
if (recoveryPswForm) {
    recoveryPswForm.addEventListener("blur", (event) => {
        if (event.target.value != "") event.target.classList.remove("is-invalid");
    }, true);
}


/////////////////////////////////////////////////////////////////////////////////////
 