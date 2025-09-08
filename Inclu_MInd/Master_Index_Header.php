<?php
global $usertitle;
//$a = $_SESSION['Nombre'][0]." ".$_SESSION['Apellidos'];
$a = $_SESSION['Nombre']." ".$_SESSION['Apellidos'];
$usertitle = substr($a,0,18);
print ("
<div style='clear:both'></div>

<div class='MenuVertical'>

<section class='app'>

<aside class='sidebar'>

	<header style='text-align:center'>
    <!--    -->
    <img class='imgtitle' src='".$rutaindex."Users/".$_SESSION['ref']."/img_admin/".$_SESSION['myimg']."' />
    
    <div class='ocultahead'>
        ".$usertitle."</br>
        ".$niv."</br>
    </div>
        <a href='#' class='ocultahead'>
            <form name='cerrar' action='".$rutaadmin."mcgexit.php' method='post'>
		<button type='submit' title='CLOSE SESSION' class='botonrojo imgButIco CloseSessionBlack' style='vertical-align:top;' ></button>
                <input type='hidden' name='cerrar' value=1 />
            </form>
        </a>

        <a href='#'>
            <i class='ic icoh'></i>
                <span class='borderhead ocultahead' style='color:#FFFFFF;vertical-align:middle'>MENU APP</span>
        </a>
    </header> ");
    
?>