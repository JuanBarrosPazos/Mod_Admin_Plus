<?php

    global $ficharCrear;
    if($ficharCrear==1){
        $link1 = "";
    }else{
        $link1 = "<a href='fichar_Crear.php'>
			<button type='button' title='FICHAR USUARIO ACTUAL' class='botonverde imgButIco Person1Black' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
		</a>";
    }

    if($ficharCrear==2){
        $link2 = "";
    }else{
        $link2 = "<a href='fichar_Crear_tds.php'>
			<button type='button' title='FICHAR VER TODOS LOS EMPLEADOS' class='botonverde imgButIco PersonsBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
		</a>";
    }

    if($ficharCrear == 3){
        $link3 = "";
    }else{
        $link3 = "<a href='fichar_Crear_otr.php'>
			<input type='hidden' name='time' value='".@$_SESSION['time']."' />
			<button type='submit' title='FICHAR FILTRO DE EMPLEADOS' class='botonverde imgButIco BuscaBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
			<input type='hidden' name='grafico2' value=1 />
		</a>";
    }

    if(($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'plus')){ 
	    print("<div class='centradiv' style='border:none !important'>".$link1.$link2.$link3."</div>");
	}else{ }



?>