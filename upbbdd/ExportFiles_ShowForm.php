<?php

	if((isset($_POST['oculto1']))||(isset($_POST['delete']))){
				$_SESSION['tablas'] = $_POST['tablas'];
				$defaults = array ('Orden' => '`id` ASC',
								   'tablas' => $_POST['tablas'],);
		//print($_SESSION['tablas']);
	}else{	unset($_SESSION['tablas']);
			$defaults = array ('Orden' => '`id` ASC',
								'tablas' => '',);
			print("<audio src='../audi/select_one_user.mp3' autoplay></audio>");
	}

	if($_SESSION['Nivel'] == 'admin'){
		print("<table class='centradiv'>
				<tr>
					<td>".$TablaTitulo."</td>
				</tr>		
				<tr>
					<td>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
				<input type='hidden' name='Orden' value='".$defaults['Orden']."' />
				<select name='tablas' style='margin-right:0.4;vertical-align:middle;'>");

		global $db;
		global $tablau;			$tablau = "`".$_SESSION['clave']."admin`";
		$sqlu =  "SELECT * FROM $tablau ORDER BY `ref` ASC ";
		$qu = mysqli_query($db, $sqlu);
		if(!$qu){
				print("Modifique la entrada L.62 ".mysqli_error($db)."<br>");
		}else{
			while($rowu = mysqli_fetch_assoc($qu)){
					print ("<option value='".$rowu['ref']."' ");
					if($rowu['ref'] == $defaults['tablas']){
								print("selected = 'selected'");
					}
					print ("> ".$rowu['Nombre']." ".$rowu['Apellidos']." </option>");
			}
		}  
			
		print ("</select>
					<button type='submit' title='".$ButtonTitulo."' class='botonlila imgButIco InicioBlack' style='vertical-align:middle;' ></button>
					<input type='hidden' name='oculto1' value=1 />
				</form>	
			</td>
		</tr>
			</table>"); 
	}

?>