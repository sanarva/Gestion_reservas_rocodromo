<?php
    unset ($_SESSION['confirmation']);   
?>
<!-- Mensaje modal de confirmación para eliminar registros-->

<div class="customModalMessage alert">
    <div class="form-group row">
    <div class="col-1 col-sm-2 col-lg-3"></div>
        <div class="col-10 col-sm-8 col-lg-6 border rounded bg-white mt-5">
            <div class="modal-header">
                <i class="fas fa-exclamation-triangle modalIcon modalIconWarning"></i>   
                <h5>ATENCIÓN:</h5>
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
            </div>
 
            <div class="modal-footer">
                <button type="button" data-dismiss="alert" class="btn btn-dark">Cancelar</button>
                <a href="../php/deleteZone.php?Id=<?php echo $_SESSION['idZone']?>&zoneName=<?php echo $_SESSION['zoneName']?>&delete=yes" class="btn btn-danger">Eliminar</a>
            </div>

        </div>
    </div>
</div>

<?php
    $_SESSION["message"] = ""; 
?>