<?php

if((@$_SESSION['Nivel'] == 'wmaster')||(@$_SESSION['Nivel'] == 'admin')){ 

    global $inicioadmin;
    $inicioadmin ="<form name='boton' action='Admin_Ver.php' method='post' style='display: inline-block;' >
            <button type='submit' title='INICIO ADMIN GESTION' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
            <input type='hidden' name='volver' value=1 />
        </form>";

    global $Feedback;   
    global $iniciobajas;
   if($Feedback == 1){
    $inciobajas ="<form name='boton' action='Admin_Ver.php' method='post' style='display: inline-block;' >
                <button type='submit' title='INICIO ADMIN' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
                <input type='hidden' name='volver' value=1 />
            </form>";
       
    }else{
    $inciobajas ="<form name='boton' action='Feedback_Ver.php' method='post' style='display: inline-block;' >
            <button type='submit' title='INICIO ADMIN BAJAS' class='botonlila imgButIco DeleteBlack' style='vertical-align:top;' ></button>
            <input type='hidden' name='volver' value=1 />
        </form>";
    }

    global $inicioadmincrear;
    $inicioadmincrear ="<form name='boton' action='Admin_Crear.php' method='post' style='display: inline-block;' >
            <button type='submit' title='ADMIN CREAR' class='botonverde imgButIco PersonAddBlack' style='vertical-align:top;' ></button>
             <input type='hidden' name='volver' value=1 />
        </form>";

    

    }else{  global $inicioadmin; $inicioadmin ="";
            global $iniciobajas; $inciobajas ="";
            global $inicioadmincrear; $inicioadmincrear ="";
    }

    global $closewindow;
    $closewindow = "<form name='closewindow' action='$_SERVER[PHP_SELF]' onsubmit=\"window.close()\">
            <button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelBlack' style='vertical-align:top;' ></button>
            <input type='hidden' name='closewin' value=1 />
        </form>";

?>