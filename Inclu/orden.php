<?php

	//global $orden;
	if(isset($_POST['Orden'])){ $orden = $_POST['Orden'];
	}elseif((isset($_GET['page']))||(isset($_POST['page']))){
		if(isset($_SESSION['Orden'])){ $orden = $_SESSION['Orden']; 
		}else{ $orden ='`id` ASC'; }
	}else{ $orden ='`id` ASC'; }

?>