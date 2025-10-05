<?php

if($Feedback==1){

	global $formularioh;
	$formularioh = "<td colspan=7 align='center' class='BorderInf'>
			<form style='display:inline-block;' name='ver' action='".@$ruta."Admin_Ver_02.php' target='popup'method='POST' onsubmit=\"window.open('', 'popup', 'width=420px,height=550px,')\">";

	global $formulariof;
	$formulariof = "<button type='submit' title='VER DETALLES' class='botonlila imgButIco DetalleBlack' style='vertical-align:top;' ></button>
			<input type='hidden' name='oculto2' value=1 />
				</form>";

	global $formulariohg;
	$formulariohg = "<form style='display:inline-block;' name='modifica' action='Feedback_Borrar.php' method='POST'>";

	global $formulariofg;
	$formulariofg = "<button type='submit' title='BORRAR DATOS EMPLEADO' class='botonrojo imgButIco DeleteBlack' style='vertical-align:top;' ></button>
					<input type='hidden' name='oculto2' value=1 />
				</form>";

	global $formulariohi;
	$formulariohi = "<form style=\"display:inline-block;\" name='modifica' action='Feedback_Recuperar.php' method='POST'>";

	global $formulariofi;
	$formulariofi = "<button type='submit' title='RECUPERAR BAJA' class='botonverde imgButIco RestoreBlack' style='vertical-align:top;' ></button>
					<input type='hidden' name='oculto2' value=1 />
				</form>";

}else{

	global $formularioh;
	$formularioh = "<form style='display:inline-block;' name='ver' action='".@$ruta."Admin_Ver_02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=380px,height=530px')\">";

	global $formulariof;
	$formulariof = "<button type='submit' title='VER DETALLES' class='botonlila imgButIco DetalleBlack' style='vertical-align:top;' ></button>
		<input type='hidden' name='oculto2' value=1 />
		</form>";

	global $formulariohg;
	$formulariohg = "<form style='display:inline-block;' name='modifica_img' action='".@$ruta."Admin_Modificar_img.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup',  'width=520px,height=450px')\">";

	global $formulariofg;
	$formulariofg = "<button type='submit' title='MODIFICAR IMAGEN' class='botonnaranja imgButIco FotoBlack' style='vertical-align:top;' ></button>
		<input type='hidden' name='oculto2' value=1 />
		</form>";

	global $formulariohi;
	$formulariohi = "<form style=\"display:inline-block;\" name='modifica' action='".@$ruta."Admin_Modificar.php' method='POST' target='popup' onsubmit=\"window.open('', 'popup', 'width=480px,height=680px')\">";

	global $formulariofi;
	$formulariofi = "<button type='submit' title='MODIFICAR DATOS' class='botonnaranja imgButIco DatosBlack' style='vertical-align:top;' ></button>
		<input type='hidden' name='oculto2' value=1 />
		</form>";
	/* 
	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){

	global $formulariohe;
	$formulariohe = "<form style=\"display:inline-block;\" name='borra' action='".@$ruta."Admin_Borrar.php' method='POST'>";

	global $formulariofe;
	$formulariofe = "<input type='submit' value='DAR DE BAJA' class='botonrojo' />
					<input type='hidden' name='oculto2' value=1 />
					</form>
					</td>";
	}else{	
		global $formulariohe;
		$formulariohe = "";
			
		global $formulariofe;
		$formulariofe = "";
		}
*/	

}


?>