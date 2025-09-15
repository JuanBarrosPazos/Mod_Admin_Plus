<?php

	global $result;			global $Feedback;

	$result =  "SELECT * FROM $table_name_a WHERE (`del` = 'false' AND `nivel` <> 'locked') ORDER BY `id` ASC";

	$q = mysqli_query($db, $result);
	$row = mysqli_fetch_assoc($q);
	$num_total_rows = mysqli_num_rows($q);
	
	// DEFINO EL NUMERO DE ARTICULOS POR PÁGINA
	global $nitem;		$nitem = 8;
	
	global $page;

    if(isset($_POST["page"])){
		global $page;		$page = $_POST["page"];
    }

    //examino la pagina a mostrar y el inicio del registro a mostrar
    if(isset($_GET["page"])){
		global $page;		$page = $_GET["page"];
    }

    if(!$page){
		global $page;		$page = 1;		$start = 0;
        
    }else{
        $start = ($page - 1) * $nitem;
    }
    
    //calculo el total de paginas
	$total_pages = ceil($num_total_rows / $nitem);
	
	// CALCULO CUANTOS RESUSTALDOS DEL TOTAL EN LA PAGINACIÓN
	global $nres;
	$nres = $page * $nitem;
	if($nres < $num_total_rows){ 
								 $nres = $nres;}
	else{ $nres = $num_total_rows;}

	//pongo el numero de registros total, el tamaño de pagina y la pagina que se muestra
	echo '<div style="clear:both"></div>
	<h3 class="textpaginacion">
		Resultados '.$nres.' de '.$num_total_rows.' || P&aacute;gina '.$page.' de ' .$total_pages.'.
	</h3>';

	global $limit;
	$limit = " LIMIT ".$start.", ".$nitem;

?>