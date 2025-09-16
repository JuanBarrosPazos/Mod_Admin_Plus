<?php

    global $ExportBotonera;
    if($ExportBotonera==1){
        $link1 = "";
    }else{
        $link1 = "<a href='Reg_Fichar_Modificar_01.php'>
			<button type='button' title='MODIFICAR HORARIOS SALIDA' class='botonverde imgButIco BbddBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
		</a>";
    }

    if($ExportBotonera==2){
        $link2 = "";
    }else{
        $link2 = "<a href='Reg_Fichar_Modificar_Error.php'>
			<button type='button' title='MODIFICAR ERRORES HORARIOS' class='botonverde imgButIco Clock2Black' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
		</a>";
    }

    /*    */
    if($ExportBotonera == 3){
        $link3 = "";
    }else{
        $link3 = "<a href='Reg_Fichar_Borrar_01.php'>
			<input type='hidden' name='time' value='".@$_SESSION['time']."' />
			<button type='submit' title='BORRAR HORARIOS' class='botonverde imgButIco DatosBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
			<input type='hidden' name='grafico2' value=1 />
		</a>";
    }

    if($ExportBotonera == 4){
        $link4 = "";
    }else{
        $link4 = "<a href='Reg_Fichar_feedback_recuperar_01.php'>
			<input type='hidden' name='time' value='".@$_SESSION['time']."' />
			<button type='submit' title='RECUPERAR HORARIOS PAPELERA' class='botonazul imgButIco HomeBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
			<input type='hidden' name='grafico2' value=1 />
		</a>";
    }

    if($ExportBotonera == 5){
        $link5 = "";
    }else{
        $link5 = "<a href='Reg_Fichar_feedback_borrar_01.php'>
			<input type='hidden' name='time' value='".@$_SESSION['time']."' />
			<button type='submit' title='ELIMINAR HORARIOS PAPELERA' class='botonazul imgButIco HomeBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
			<input type='hidden' name='grafico2' value=1 />
		</a>";
    }

    if($ExportBotonera == 4){
        $link4 = "";
    }else{
        $link4 = "<a href='../Admin/Admin_Ver.php'>
			<input type='hidden' name='time' value='".@$_SESSION['time']."' />
			<button type='submit' title='FICHAR FILTRO DE EMPLEADOS' class='botonazul imgButIco HomeBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
			<input type='hidden' name='grafico2' value=1 />
		</a>";
    }

    if(($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'plus')){ 
        print("<div class='centradiv' style='border:none !important'>".$link1.$link2.$link3.$link4."</div>");
    }else{ }


?>