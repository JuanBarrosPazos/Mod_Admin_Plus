<?php

	if($_SESSION['Nivel'] == 'admin'){

		master_index();
		global $InfoLog;			global $InfoLogB;

		if(@$_POST['oculto2']){ show_form();
								$InfoLog = "** USER BAJAS BORRAR SELECCIONADO ";
								$InfoLogB = "";
								UserLog();

		}elseif($_POST['borrar']){	process_form();
									deletedir();
									deleteUserDir();
									$InfoLog = "** USER BAJAS BORRARDO ";
									$InfoLogB = $deletet.PHP_EOL.$ddr;
									UserLog();
		}else{ show_form(); }

	}else{ require '../Inclu/tabla_permisos.php'; }

?>