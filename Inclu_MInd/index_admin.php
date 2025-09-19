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
				</li>");
		}else{ }

	if($_SESSION['Nivel'] == 'admin') {
		print(" <li>
					<a href='".$rutafichar."Reg_Fichar_Ver.php'>
						<i class='ic ico19'></i><span>REGISTROS IN / OUT</span>
					</a>
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

		print("	<li>
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