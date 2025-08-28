<?php

		print("<table class='TFormAdmin'>
				<tr>
					<th colspan=2>NUEVO ADMINISTRADOR</th>
				</tr>
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'  enctype='multipart/form-data'>
				<tr>
					<td>NOMBRE:</td>
					<td>
		<input type='text' name='Nombre' size=28 maxlength=25 pattern='[a-zA-Z\s]{3,25}' placeholder='MI NOMBRE' value='".$defaults['Nombre']."' required />
					</td>
				</tr>
				<tr>
					<td>APELLIDOS:</td>
					<td>
		<input type='text' name='Apellidos' size=28 maxlength=25 pattern='[a-zA-Z\s]{3,25}' placeholder='MIS APELLIDOS' value='".$defaults['Apellidos']."' required />
					</td>
				</tr>
				<tr>
					<td>DOCUMENTO:</td>
					<td>
		<select name='doc' required >");
				foreach($doctype as $option => $label){
					print ("<option value='".$option."' ");
					if($option == $defaults['doc']){print ("selected = 'selected'");}
													print ("> $label </option>");
												}	
		print ("</select>
					</td>
				</tr>
				<tr>
					<td>N&Uacute;MERO:</td>
					<td>
		<input type='text' name='dni' size=12 maxlength=8 pattern='[0-9]{8,8}' placeholder='NUM. DOC.' value='".$defaults['dni']."' required />
					</td>
				</tr>
				<tr>
					<td>CONTROL:</td>
					<td>
		<input type='text' name='ldni' size=4 maxlength=1 pattern='[A-Z]{1,1}' value='".$defaults['ldni']."' required />
					</td>
				</tr>
				<tr>
					<td>MAIL:</td>
					<td>
		<input type='mail' name='Email' size=32 maxlength=50 placeholder='MI EMAIL EN MINUSCULAS' value='".$defaults['Email']."' required />
					</td>
				</tr>	
				<tr>
					<td>NIVEL USER:</td>
					<td>
		<select name='Nivel' required >");
			foreach($Nivel as $optionnv => $labelnv){
				print ("<option value='".$optionnv."' ");
				if($optionnv == $defaults['Nivel']){ print ("selected = 'selected'");}
													 print ("> $labelnv </option>");
						}	
	print ("</select>
					</td>
				</tr>
				<tr>
					<td>USER NICK:</td>
					<td>
		<input type='text' name='Usuario' size=12 maxlength=10 pattern='[a-z A-Z 0-9\s]{3,10}' placeholder='MI NICK' value='".$defaults['Usuario']."' required />
					</td>
				</tr>
				<tr>
					<td>USER NICK:</td>
					<td>
		<input type='text' name='Usuario2' size=12 maxlength=10 pattern='[a-z A-Z 0-9\s]{3,10}' placeholder='MI NICK' value='".$defaults['Usuario2']."' required />
					</td>
				</tr>
				<tr>
					<td>PASSWORD:</td>
					<td>
		<input type='text' name='Password' size=12 maxlength=10 pattern='[a-z A-Z 0-9\s]{3,10}' placeholder='MI PASSWORD' value='".$defaults['Password']."' required />
					</td>
				</tr>
				<tr>
					<td>PASSWORD:
					</td>
					<td>
		<input type='text' name='Password2' size=12 maxlength=10 pattern='[a-z A-Z 0-9\s]{3,10}' placeholder='MI PASSWORD' value='".$defaults['Password2']."' required />
					</td>
				</tr>
				<tr>
					<td>DIRECCION:</td>
					<td>
		<input type='text' name='Direccion' size=32 maxlength=60 placeholder='MI DIRECCION' value='".$defaults['Direccion']."' required />
					</td>
				</tr>
				<tr>
					<td> TELEFONO 1:</td>
					<td>
		<input type='text' name='Tlf1' size=12 maxlength=9 pattern='[0-9]{9,9}' placeholder='TELEFONO 1' value='".$defaults['Tlf1']."' required />
					</td>
				</tr>
				<tr>
					<tr>
					<td>TELEFONO 2:</td>
					<td>
		<input type='text' name='Tlf2' size=12 maxlength=9 pattern='[0-9\s]{9,9}' placeholder='TELEFONO 2' value='".$defaults['Tlf2']."' />
					</td>
				</tr>
				<tr>
					<td colspan='2'>
			<button type='submit' title='GUARDAR DATOS' class='botonverde imgButIco SaveBlack' style='vertical-align:top;' ></button>
			<input type='hidden' name='oculto' value=1 />
		</form>".$inicioadmin."
					</td>
				</tr>
			</table>"); 



?>