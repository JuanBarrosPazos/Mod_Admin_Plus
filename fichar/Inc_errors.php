<?php

	global $sesus;
	if($sesus==''){ $sesus = $_SESSION['ref']; }
	else{ /*$sesus = $_SESSION['webmaster'];*/ }	
	
	$tablae = $_SESSION['clave'].$sesus;
	$tablae = strtolower($tablae);
	global $vname;		$vname = "`".$tablae."_".date('Y')."`";
	//echo "* ".$vname;

	// INICIO ERRORES FICHAR.
		global $db;		global $db_name;
	$sqle =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`ttot` = '03:22:02' ";
		$qe = mysqli_query($db, $sqle);
		global $counte;
		if(!$qe){
			echo "* ERROR L.12 ".mysqli_error($db);
		}else{
			$counte = mysqli_num_rows($qe);
		}

	if($counte > 0){
		
		print("<table align='center' style='margin-top:10px' width=450px >
				<tr>
					<th colspan=5 class='BorderInf'>
						<b>
						<font color='#FF0000'>
							".$sesus." EXISTEN ERRORES EN SUS HORARIOS.
						</font>
						</b>
					</th>
				</tr>
				<tr>
					<td class='BorderInfDch'>ID</td>
					<td class='BorderInfDch'>D. IN</td>
					<td class='BorderInfDch'>T. IN</td>
					<td class='BorderInfDch'>D. OUT</td>
					<td class='BorderInf'>T. OUT</td>
				</tr>");
		
		while($rowe = mysqli_fetch_assoc($qe)){
			
			print("	<tr>
						<td class='BorderInfDch'>".$rowe['id']."</td>
						<td class='BorderInfDch'>".$rowe['din']."</td>
						<td class='BorderInfDch'>".$rowe['tin']."</td>
						<td class='BorderInfDch'>".$rowe['dout']."</td>
						<td class='BorderInf'>".$rowe['tout']."</td>
					</tr>");
			
				} // FIN DEL WHILE.
		
		print("		<tr>
					<th colspan=5 class='BorderInf'>
						<b>
						<font color='#FF0000'>PONGASE EN CONTACTO CON ADMIN SYSTEM.</font>
						</b>
					</th>
				 </tr>
				</table>");
	} else{}

?>