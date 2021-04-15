<!-- Mensaje modal -->
<?php if (isset($_SESSION["successFlag"]) && $_SESSION["successFlag"] != "") { ?> 
    <div class="customModalMessage alert">
        <div class="form-group row">
        <div class="col-1 col-sm-2 col-lg-3"></div>
            <div class="col-10 col-sm-8 col-lg-6 border rounded bg-white mt-5">
                <div class="modal-header">
                    <?php if ($_SESSION["successFlag"] == "N") { ?>
                        <i class="fas fa-times-circle modalIcon modalIconError"></i> 
                        <h5>ERROR:</h5>
                    <?php } ?>
                    <?php if ($_SESSION["successFlag"] == "C") { ?>
                        <i class="fas fa-times-circle modalIcon modalIconError"></i> 
                        <h5>ERROR CONEXIÓN SISTEMA:</h5>
                    <?php } ?>
                    <?php if ($_SESSION["successFlag"] == "Y") { ?>
                        <i class="fas fa-check-circle modalIcon modalIconCorrect"></i>  
                        <h5>OPERACIÓN CORRECTA:</h5>
                    <?php } ?>
                    <?php if ($_SESSION["successFlag"] == "W") { ?>
                        <i class="fas fa-exclamation-triangle modalIcon modalIconWarning"></i>   
                        <h5>ATENCIÓN:</h5>
                    <?php } ?>
                    <button 
                        type="button" 
                        class="close" 
                        data-dismiss="alert" 
                        aria-label="Close"
                    >
                    <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body">
                    <p><?=$_SESSION["message"] ?></p>
                    <?php if (isset($_SESSION['form'])) { ?>
                        <p class="text-center"> <input type="number" min="1" max = "999999" name="ropeTeam"> </p>
                    <?php } ?>
                </div>

                <?php if ($_SESSION["successFlag"] != "C" ) { ?>
                    <div class="modal-footer">
                        <?php if (isset($_SESSION["formaction1"]) && $_SESSION["formaction1"] != "") { ?>
                            <a href="<?php echo $_SESSION["formaction1"]?>" class="btn <?=$_SESSION["colorbutton1"]?>"><?php echo $_SESSION["button1"]?></a>
                        <?php }?>
                        <?php if (isset($_SESSION["formaction2"]) && $_SESSION["formaction2"] != "") { ?>
                            <a href="<?php echo $_SESSION["formaction2"]?>" class="btn <?=$_SESSION["colorbutton2"]?>" <?php if (isset($_SESSION["datadismiss"]) && $_SESSION["datadismiss"] =! "") {?>data-dismiss="alert" <?php }?> > <?php echo $_SESSION["button2"]?></a>
                        <?php }?>    
                    </div>
                <?php }?> 
            </div>
        </div>
    </div>
                              
    <!-- Inicializamos las variables de sesión relacionadas con el mensaje modal una vez que hemos mostrado el mensaje -->
        
<?php 
    $_SESSION["successFlag"]  = "";
    $_SESSION["message"]      = "";
    $_SESSION["button1"]      = "";
    $_SESSION["formaction1"]  = "";
    $_SESSION["colorbutton1"] = "";
    $_SESSION["button2"]      = "";
    $_SESSION["colorbutton2"] = "";
    $_SESSION["formaction2"]  = "";
    $_SESSION["datadismiss"]  = "";
    unset ($_SESSION['form']);
}?>


