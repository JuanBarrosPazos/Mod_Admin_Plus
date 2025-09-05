<?php

if /*(*/($_SESSION['Nivel'] == 'admin')/* || ($_SESSION['Nivel'] == 'plus'))*/{

    master_index();

    global $InfoLog;
    if(isset($_POST['oculto2'])){   show_form();
                                    $InfoLog = "** ADMIN BORRAR SELECCIONADO ";
                                    UserLog();
    }elseif(isset($_POST['borrar'])){	process_form();
                                         $InfoLog = "** ADMIN BORRADO ";
                                         UserLog();
    }else{ show_form(); }

}else{ require '../Inclu/tabla_permisos.php'; }

?>