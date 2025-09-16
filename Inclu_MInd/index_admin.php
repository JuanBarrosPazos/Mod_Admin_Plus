<?php

	if(($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'plus')||($_SESSION['Nivel'] == 'user')){

	print("<li>
				<a href='".$rutaadmin."Admin_Ver.php'>
					<i class='ic ico13'></i>EMPLEADOS
				</a>
			</li>
			<li>
				<a href='".$rutafichar."Fichar_Crear.php'>
					<i class='ic ico12'></i><span>FICHAR IN / OUT</span>
				</a>
			</li>
					");
	}else{ }

	if($_SESSION['Nivel'] == 'admin') {
		print(" <li>
				<a href='#'>
					<i class='ic ico19'></i><span>REGISTROS IN / OUT</span>
				</a>
				<ul class='nav-flyout'>
					<li>
						<a href='".$rutafichar."Reg_Fichar_Modificar_01.php' ".$topcat2.">
							<i class='ic ico19b'></i>MODIF. OUT
						</a>
					</li>
					<li>
						<a href='".$rutafichar."Reg_Fichar_Modificar_Error.php'>
							<i class='ic ico19b'></i>MODIF. ERROR
						</a>
					</li>
					<li>
						<a href='".$rutafichar."Reg_Fichar_Borrar_01.php'>
							<i class='ic ico19b'></i>BORRA REG.
						</a>
					</li>
					<li>
						<a href='".$rutafichar."Reg_Fichar_feedback_recuperar_01.php'>
							<i class='ic ico19b'></i>RECUPERA REG.
						</a>
					</li>
					<li>
						<a href='".$rutafichar."Reg_Fichar_feedback_borrar_01.php'>
							<i class='ic ico19b'></i>ELIMINA REG.
						</a>
					</li>
				</ul>
			</li>
	
			<li>
				<a href='".$rutabalance."Balances.php'>
					<i class='ic ico26'></i><span>BALANCES</span>
				</a>
			</li>
		
			<li>
				<a href='".$rutaupbbdd."bbdd.php'>
					<i class='ic ico02'></i><span>RESPALDO DATOS</span>
				</a>
			</li>
	
			<li>
				<a  href='".$rutaqrgen."indexqrg.php'>
					<i class='ic ico20'></i><span>QR CODES</span></a>
			</li>");
	}else{ }

	print("<li>
			<a href='".$rutaindex."Mail_Php/index.php' target='_blank'>
				<i class='ic ico16'></i>NOTIFICACIONES
			</a>
		</li>
		<li style='text-align:center;'>
			<a href='#'>
				<form name='cerrar' action='".$rutaadmin."mcgexit.php' method='post'>
		<button type='submit' title='CLOSE SESSION' class='botonrojo imgButIco CloseSessionBlack' style='vertical-align:top;margin-top:-0.3em !important' ></button>
			<input type='hidden' name='cerrar' value=1 />
				</form>
			</a>
		</li>
				</ul>
			</nav>
		</aside>
	</section>
</div>");

?>