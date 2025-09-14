<?php

if($_SESSION['Nivel'] == 'admin'){

	master_index();

	if(isset($_POST['todo'])){	show_form();							
								ver_todo();
	}else{ 	show_form(); 
			ver_todo(); 
	}
								
}else{ require '../Inclu/tabla_permisos.php'; }


?>