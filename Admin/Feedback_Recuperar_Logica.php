<?php

if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){

    master_index();

    global $InfoLog;
    if(isset($_POST['oculto2'])){   show_form();
                                    $InfoLog = "** ADMIN FEEDBACK RECUPERADO ";
                                    UserLog();
    }elseif(isset($_POST['modifica'])){ process_form();
                                        $InfoLog = " ";
                                        UserLog();
    }else{ show_form(); }

}else{ require '../Inclu/tabla_permisos.php'; }

?>