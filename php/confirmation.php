<?php
    unset ($_SESSION["confirmation"]); 
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
                <button type="button" data-dismiss="alert" class="btn btn-dark">Volver</button>
                <?php 
                switch ($_SESSION["page"]){ 
                    case "zone": ?>
                        <a href="../php/deleteZone.php?Id=<?php echo $_SESSION['idZone']?>&zoneName=<?php echo $_SESSION['zoneName']?>&delete=yes" class="btn btn-danger">Eliminar</a>
                    <?php ; 
                        break;
                    case "hour":?>
                        <a href="../php/deleteHour.php?Id=<?php echo $_SESSION['idHour']?>&startHour=<?php echo $_SESSION['startHour']?>&endHour=<?php echo $_SESSION['endHour']?>&delete=yes" class="btn btn-danger">Eliminar</a>
                    <?php ; 
                        break; 
                    case "user":?>
                        <a href="../php/deleteUser.php?Id=<?php echo $_SESSION['idUser']?>&userName=<?php echo $_SESSION['userName']?>&delete=yes" class="btn btn-danger">Eliminar</a>
                    <?php ; 
                        break; 
                    case "reservation":?>
                        <a href="../php/deleteReservation.php?Id=<?php echo $_SESSION['idReservation']?>&idRelatedReservation=<?php echo $_SESSION['idRelatedReservation']?>&delete=yes" class="btn btn-danger">Eliminar</a>
                    <?php ; 
                        break; 
                    case "cancelReservation":?>
                        <a href="../php/updateReservation.php?idReservation=<?php echo $_SESSION['cancelIdReservation']?>&idRelatedReservation=<?php echo $_SESSION['cancelIdRelatedReservation']?>&userId=<?php echo $_SESSION['cancelUserId']?>&userName=<?php echo $_SESSION['cancelUserName']?>&cancelReservation&cancel=yes&reservationDate=<?php echo $_SESSION['cancelReservationDate']?>&startHour=<?php echo $_SESSION['cancelStartHour']?>&endHour=<?php echo $_SESSION['cancelEndHour']?>&zoneName=<?php echo $_SESSION['cancelZoneName']?>" class="btn btn-danger">Cancelar</a>
                    <?php ; 
                        break; 
                    }    ?>    
                
            </div>

        </div>
    </div>
</div>

<?php
    $_SESSION["message"] = ""; 
    unset ($_SESSION["page"]);

    if (isset($_SESSION['idReservation'])){
        unset ($_SESSION['idReservation']);
    }
    
    if (isset($_SESSION['idRelatedReservation'])){
        unset ($_SESSION['idRelatedReservation']);
    }

    if (isset($_SESSION['cancelIdReservation'])){
        unset ($_SESSION['cancelIdReservation']);
    }

    if (isset($_SESSION['cancelIdRelatedReservation'])){
        unset ($_SESSION['cancelIdRelatedReservation']);
    }

    if (isset($_SESSION['cancelUserId'])){
        unset ($_SESSION['cancelUserId']);
    }

    if (isset($_SESSION['cancelUserName'])){
        unset ($_SESSION['cancelUserName']);
    }

    if (isset($_SESSION['cancelReservationDate'])){
        unset ($_SESSION['cancelReservationDate']);
    }

    if (isset($_SESSION['cancelStartHour'])){
        unset ($_SESSION['cancelStartHour']);
    }

    if (isset($_SESSION['cancelEndHour'])){
        unset ($_SESSION['cancelEndHour']);
    }

    if (isset($_SESSION['cancelZoneName'])){
        unset ($_SESSION['cancelZoneName']);
    }
?>

