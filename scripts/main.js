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

//Variable necesaria para determinar si existe o no formulario de usuarios 
let reservationsConfigForm = document.getElementById("reservationsConfigForm");

//Variable necesaria para determinar si existe o no formulario de búsqueda de reservas disponibles 
let searchReservationForm = document.getElementById("searchReservationForm");

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
    } else if (isNaN(maxUserNumber.value)) {
        maxUserNumber.classList.add("is-invalid");
        errorMaxUserNumber.textContent = "El número máximo de usuarios por zona debe ser un número del 1 al 99";
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


//Función usada para hacer las validaciones del formulario de configuración de reservas antes de hacer la petición al servidor
function validateReservationsConfigForm(){
    //Inicializamos los errores
    totalErrors = 0;

    //Recuperamos el valor del número máximo de reservas por usuario y validamos su formato
    let maxReservationsByUser = document.getElementById("maxReservationsByUser");
    let errorMaxReservationsByUser = document.getElementById("errorMaxReservationsByUser");
    if (maxReservationsByUser.value == "" || maxReservationsByUser.value == "0") {
        maxReservationsByUser.classList.add("is-invalid");
        errorMaxReservationsByUser.textContent = "Por favor, escribe un número máximo de reservas por usuario (de 1 a 99)";
        totalErrors++;
    } else if (isNaN(maxReservationsByUser.value)) {
        maxReservationsByUser.classList.add("is-invalid");
        errorMaxReservationsByUser.textContent = "El número máximo de de reservas por usuario debe ser un número del 1 al 99";
        totalErrors++;
    }

    //Recuperamos la fecha de apertura de las reservas y la validamos 
    let startFreeDate = document.getElementById("startFreeDate");
    let errorStartFreeDate = document.getElementById("errorStartFreeDate");
    if (startFreeDate.value == "") {
        startFreeDate.classList.add("is-invalid");
        errorStartFreeDate.textContent = "Por favor, selecciona la fecha de apertura de reservas";
        totalErrors++;
    }

    //Recuperamos la fecha de cierre de las reservas y la validamos 
    let endFreeDate = document.getElementById("endFreeDate");
    let errorEndFreeDate = document.getElementById("errorEndFreeDate");
    if (endFreeDate.value == "") {
        endFreeDate.classList.add("is-invalid");
        errorEndFreeDate.textContent = "Por favor, selecciona la fecha de cierre de reservas";
        totalErrors++;
    } else if (endFreeDate.value < startFreeDate.value){
        endFreeDate.classList.add("is-invalid");
        errorEndFreeDate.textContent = "La fecha de cierre de reservas debe ser mayor que la fecha de apertura de reservas";
        totalErrors++;
    }
    
    if (totalErrors > 0) {
        return false;
    } else {
        reservationsConfigForm.action = "../php/updateReservationConfig.php";
    }
}


//Función usada para hacer las validaciones del formulario de búsqueda de reservas disponibles
function validateSearchReservation(){
    //Inicializamos los errores
    totalErrors = 0;

    //Recuperamos el nombre del usuario al que irá la reserva 
    let filterUserName = document.getElementById("filterUserName");
    let errorFilterUserName = document.getElementById("errorFilterUserName");
    if (filterUserName.value == "") {
        filterUserName.classList.add("is-invalid");
        errorFilterUserName.textContent = "Por favor, introduce el nombre de usuario asociado a la reserva";
        totalErrors++;
    }

    //Recuperamos la fecha elejida y la validamos 
    let reservationDateChoosen = document.getElementById("reservationDateChoosen");
    let errorReservationDateChoosen = document.getElementById("errorReservationDateChoosen");
    if (reservationDateChoosen.value == "") {
        let reservationDateChoosenMin = formatDate(reservationDateChoosen.min);
        let reservationDateChoosenMax = formatDate(reservationDateChoosen.max);

        reservationDateChoosen.classList.add("is-invalid");
        errorReservationDateChoosen.textContent = "Por favor, selecciona una fecha del " + reservationDateChoosenMin + " al " + reservationDateChoosenMax;
        totalErrors++;
    }

    //Recuperamos las horas 
    let filterStartHour = document.getElementById("filterStartHour");
    let filterEndHour   = document.getElementById("filterEndHour");
    let errorFilterEndHour = document.getElementById("errorFilterEndHour");

    if (filterEndHour.value < filterStartHour.value){
        filterEndHour.classList.add("is-invalid");
        errorFilterEndHour.textContent = "La hora de finalizacion debe ser mayor que la de inicio.";
        totalErrors++;
    }
 
    //Recuperamos el valor del idReservation para saber si tenemos que llamar en modo alta o modificación
    let idReservationRetrieved = document.getElementById("idReservation").innerHTML; 
    
    if (totalErrors > 0) {
        return false;
    } else {
        searchReservationForm.action = "../php/searchAvailableReservations.php?idReservation=" + idReservationRetrieved;
    }
}

//Función usada para hacer las reservas
function reservate(){

    //Recuperamos la reserva elegida
    let reservationChoosen = document.reservationForm.reservationChoosenArray.value;
    
    //La convertimos en array
    let reservationChoosenArray = reservationChoosen.split(", ");  
    
    //Obtenemos los datos del array
    for (i=0; i < reservationChoosenArray.length; i++){
        if (i == 0 ){
            idHour = reservationChoosenArray[0];
        }
        if (i == 1 ){
            idZone = reservationChoosenArray[1];
        }
    }
    
    let reservationButton = document.getElementById("reservationButton"); 

    reservationButton.formAction = reservationButton.formAction + "&idHour=" + idHour + "&idZone=" + idZone;
 
}


//Función usada para pasar fechas de aaaa-mm-dd a dd/mm/aaaa
function formatDate(dateToBeFormated) {
    return (dateToBeFormated.substring(8, 10) + "/" + dateToBeFormated.substring(5, 7) + "/" + dateToBeFormated.substring(0,4));
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

if (reservationsConfigForm) {
    reservationsConfigForm.addEventListener("blur", (event) => {
        if (event.target.value != "") event.target.classList.remove("is-invalid");
    }, true);
}

if (searchReservationForm) {
    searchReservationForm.addEventListener("blur", (event) => {
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
 