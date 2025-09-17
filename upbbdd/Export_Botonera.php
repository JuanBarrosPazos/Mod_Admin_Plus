<?php

    global $ExportBotonera;
    if($ExportBotonera==1){
        $link1 = "";
    }else{
        $link1 = "<a href='bbdd.php'>
			<button type='button' title='EXPORT BBDD & TABLES' class='botonverde imgButIco BbddBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
		</a>";
    }

    if($ExportBotonera==2){
        $link2 = "";
    }else{
        $link2 = "<a href='export_res_mes.php'>
			<button type='button' title='EXPORT TIME REG TXT' class='botonverde imgButIco Clock2Black' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
		</a>";
    }

    /*    */
    if($ExportBotonera == 3){
        $link3 = "";
    }else{
        $link3 = "<a href='export_log.php'>
			<input type='hidden' name='time' value='".@$_SESSION['time']."' />
			<button type='submit' title='EXPORT SYSTEM LOG' class='botonverde imgButIco DatosBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
			<input type='hidden' name='grafico2' value=1 />
		</a>";
    }

        if($ExportBotonera == 4){
        $link4 = "";
    }else{
        $link4 = "<a href='../Admin/Admin_Ver.php'>
			<input type='hidden' name='time' value='".@$_SESSION['time']."' />
			<button type='submit' title='INICIO EMPLEADOS' class='botonazul imgButIco HomeBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
			<input type='hidden' name='grafico2' value=1 />
		</a>";
    }

    if(($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'plus')){ 
        print("<div class='centradiv' style='border:none !important'>".$link1.$link2.$link3.$link4."</div>");
    }else{ }


?>