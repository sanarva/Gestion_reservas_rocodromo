<!-- Mensajes de error -->
<?php if (isset($_SESSION['successFlag']) && $_SESSION['successFlag'] == "N" && $_SESSION['message'] != "") { ?>
    <div class="form-group row">
    <div class="col-lg-1"></div>
        <div class="col-lg-10  alert  dialogError" >            
            <button 
                type="button" 
                class="close colorXErrorIcon" 
                data-dismiss="alert" 
                aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <i class="fas fa-exclamation-triangle"></i> <?=$_SESSION["message"] ?>
        </div>  
    </div>
<?php }?>

 <!-- Mensajes de aviso -->
<?php if (isset($_SESSION['successFlag']) && $_SESSION['successFlag'] == "W" && $_SESSION['message'] != "") { ?>
    <div class="form-group row">
    <div class="col-lg-1"></div>
        <div class="col-lg-10  alert  dialogWarning" >            
            <button 
                type="button" 
                class="close colorXWarningIcon" 
                data-dismiss="alert" 
                aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <i class="fas fa-exclamation-triangle"></i> <?=$_SESSION["message"] ?>
        </div>  
    </div>
<?php }?>


<!-- Mensajes de confirmación -->
<?php if (isset($_SESSION['successFlag']) && $_SESSION['successFlag'] == "Y" && $_SESSION['message'] != "") { ?>
    <div class="form-group row">
    <div class="col-lg-1"></div>
        <div class="col-lg-10  alert  dialogCorrect">
            <button 
                type="button" 
                class="close colorXOkIcon" 
                data-dismiss="alert" 
                aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <i class="fas fa-check-circle"></i> <?=$_SESSION["message"] ?>
        </div>  
    </div>
<?php }?>

<!-- Iniciaremos el flag una vez gestionado el mensaje -->
<?php 
    $_SESSION["successFlag"] = "";
    $_SESSION["message"] = "";
?>