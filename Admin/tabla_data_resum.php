<?php
    
	global $rf;
    if($rf == ''){
		$rf = $_POST['ref'];
	}elseif(isset($_SESSION['refcl'])){
		$rf = $_SESSION['refcl'];
	}else{ }

	global $pass;
       if(!isset($_POST['Pass'])){ 
		$pass = $_POST['Password'];
	}else{ 
		$pass = $_POST['Pass'];
	}

		print("<tr>
				<td style='width:120px;'>Nombre: </td>
				<td style='width:110px;text-align:left !important;' >".$_POST['Nombre']."</td>
				<td rowspan='5' style='text-align:center !important;'>
					<img ".$rutaimg." height='120px' width='90px' />
				</td>
			</tr>
			<tr>
				<td>Apellidos: </td>
				<td>".$_POST['Apellidos']."</td>
			</tr>				
			<tr>
				<td>Documento: </td>
				<td style=''>".$_POST['doc']."</td>
			</tr>				
			<tr>
				<td>N&uacute;mero: </td>
				<td>".$_POST['dni']."</td>
			</tr>				
			<tr>
				<td>Control: </td>
				<td>".$_POST['ldni']."</td>
			</tr>				
			<tr>
				<td>Mail: </td>
				<td>".$_POST['Email']."</td>
			</tr>
			<tr>
				<td>Nivel: </td>
				<td>".$_POST['Nivel']."</td>
			</tr>
			<tr>
				<td>Referencia: </td>
				<td colspan='2'>".$rf."</td>
			</tr>
			<tr>
				<td>Usuario: </td>
				<td colspan='2'>".$_POST['Usuario']."</td>
			</tr>
			<tr>
				<td>Password: </td>
				<td colspan='2'>".$pass."</td>
			</tr>
			<tr>
				<td>Pais: </td>
				<td colspan='2'>".$_POST['Direccion']."</td>
			</tr>
			<tr>
				<td>Teléfono 1: </td>
				<td colspan='2'>".$_POST['Tlf1']."</td>
			</tr>
			<tr>
				<td>Teléfono 2: </td>
				<td colspan='2'>".$_POST['Tlf2']."</td>
			</tr>");

	$BorradoD = substr($_POST['borrado'],0,10);
	$BorradoT = substr($_POST['borrado'],-8);
	
	if($BorradoD!=''){
		print("<tr>
				<td>Del Date: </td>
				<td>".$BorradoD."</td>
			</tr>
			<tr>
				<td>Del Time: </td=>
				<td>".$BorradoT."</td>
			</tr>");
	}else{ }
				
?>