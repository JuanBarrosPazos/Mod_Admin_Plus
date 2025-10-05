<?php

	global $sesus;
	if($sesus==''){ $sesus = $_SESSION['ref']; }else{ }	
	
	$tablae = $_SESSION['clave'].$sesus;
	$tablae = strtolower($tablae);
	global $vname;		$vname = "`".$tablae."_".date('Y')."`";
	//echo "* ".$vname;

	// INICIO ERRORES FICHAR.
		global $db;		global $db_name;
		$sqle =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`error` = 'true' ";
		$qe = mysqli_query($db, $sqle);
		global $counte;
		if(!$qe){
			echo "* ERROR L.14 ".mysqli_error($db);
		}else{
			$counte = mysqli_num_rows($qe);
		}

	if($counte > 0){
		print("<table class='centradiv alertdiv'>
				<tr>
					<th colspan=5 class='BorderInfY'>
							".$sesus." EXISTEN ERRORES EN SUS HORARIOS
					</th>
				</tr>
				<tr>
					<td class='BorderInfDchY'>ID</td>
					<td class='BorderInfDchY'>D. IN</td>
					<td class='BorderInfDchY'>T. IN</td>
					<td class='BorderInfDchY'>D. OUT</td>
					<td class='BorderInfY'>T. OUT</td>
				</tr>");
		
		while($rowe = mysqli_fetch_assoc($qe)){
			
			print("<tr>
					<td class='BorderInfDchY'>".$rowe['id']."</td>
					<td class='BorderInfDchY'>".$rowe['din']."</td>
					<td class='BorderInfDchY'>".$rowe['tin']."</td>
					<td class='BorderInfDchY'>".$rowe['dout']."</td>
					<td class='BorderInfY'>".$rowe['tout']."</td>
				</tr>");
			
				} // FIN DEL WHILE.
		
			print("<tr>
					<th colspan=5>
						PONGASE EN CONTACTO CON ADMIN SYSTEM
					</th>
				 </tr>
				</table>");
	} else{}

?>