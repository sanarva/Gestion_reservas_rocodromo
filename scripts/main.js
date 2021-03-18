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
//(Mínimo 8 caracteres, máximo 15, mínimo 1 mayúscula, mínimo 1 minúscula, mínimo 1 número, no espacios)
function validateFormatPassword(password) {
    const regexPassword = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,8}$/;
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


//Función usada para hacer las validaciones del formulario de horas antes de hacer la petición al servidor
function validateHourForm(btnClicked){
    //Inicializamos los errores
    totalErrors = 0;

    let action = document.getElementById(btnClicked).formAction;

    //Recuperamos el valor de la hora de inicio y validamos su formato
    let startHour = document.getElementById("startHour");
    let errorStartHour = document.getElementById("errorStartHour");
    if (startHour.value == "") {
        startHour.classList.add("is-invalid");
        errorStartHour.textContent = "Por favor, escribe una hora de inicio";
        totalErrors++;
    }

    //Recuperamos el valor de la hora de fin y validamos su formato
    let endHour = document.getElementById("endHour");
    let errorEndHour = document.getElementById("errorEndHour");
    if (endHour.value == "") {
        endHour.classList.add("is-invalid");
        errorEndHour.textContent = "Por favor, escribe una hora de finalización";
        totalErrors++;
    }

    //Comprobamos que la hora de finalización sea mayor que la hora de inicio
    if (startHour.value > endHour.value ) {
        endHour.classList.add("is-invalid");
        errorEndHour.textContent = "La hora de finalización debe ser mayor a la de inicio";
        totalErrors++;
    }
    
    //Comprobamos que se haya marcado algún día de la semana (lo haremos contando las checkbox con nombre = day que tiene el formulario hourForm)
    let checkboxesDay = document.getElementById("hourForm").day;
    let counterDays = 0;
     
    for(i = 0; i < checkboxesDay.length && counterDays == 0; i++) {
        if (checkboxesDay[i].checked) {
            counterDays++;
        }
    }

    let weekDayArray = [];
    let weekDayString = "";
    
    if (counterDays == 0) {
        weekDay.classList.add("is-invalid"); 
        errorWeekDay.classList.add("d-block"); 
        errorWeekDay.textContent = "Por favor, selecciona al menos un día";
        totalErrors++;
    } else {
        for(i = 0; i < checkboxesDay.length; i++){
            if (checkboxesDay[i].checked) {
                weekDayArray.push(checkboxesDay[i].value);
            }
        }
        
        weekDayString = weekDayArray.join(""); 
        weekDay.value = weekDayString;
    }


    if (totalErrors > 0) {
        return false;
    } else {
        hourForm.action = action;
    }
}


/////////////////////////////////////////////////////////////////////////////////////
//Si el formulario existe, al retirar el foco quitaremos la clase "is-invalid".    //
/////////////////////////////////////////////////////////////////////////////////////

//Ocultar errores en formulario de login
if (loginForm) {
    loginForm.addEventListener("blur", (event) => {
        if (event.target.value != "") event.target.classList.remove("is-invalid");
    }, true);
}

//Ocultar errores en formulario de cambio de contraseña
if (modifyPasswordForm) {
    modifyPasswordForm.addEventListener("blur", (event) => {
        if (event.target.value != "") event.target.classList.remove("is-invalid");
    }, true);
}

//Ocultar errores en formulario de zonas
if (zoneForm) {
    zoneForm.addEventListener("blur", (event) => {
        if (event.target.value != "") event.target.classList.remove("is-invalid");
    }, true);
}

//Ocultar errores en formulario de horas
if (hourForm) {
    hourForm.addEventListener("blur", (event) => {
        if (event.target.value != "" ) event.target.classList.remove("is-invalid");
    }, true);
}

//Ocultar error en formulario de horas si se hace click en algún día de la semana
if(hourForm){
    let checkboxesDay = document.getElementById("hourForm").day;
    
    for(i = 0; i < checkboxesDay.length; i++) {
        checkboxesDay[i].addEventListener("change", validate, true);
    }
}

function validate(day){
    if(monday.checked || tuesday.checked || wednesday.checked || thursday.checked || friday.checked || saturday.checked || sunday.checked){
        errorWeekDay = document.getElementById("errorWeekDay");
        errorWeekDay.classList.remove("d-block"); 
    }
}
 

/////////////////////////////////////////////////////////////////////////////////////
