<?php

    if(isset($_POST['ocultoc'])){
        $defaults = $_POST;
        $_SESSION['Orden'] = @$_POST['Orden'];
    }elseif(isset($_POST['todo'])){
        $defaults = $_POST;
        $_SESSION['Orden'] = $_POST['Orden'];
    }elseif((isset($_GET['page'])) || (isset($_POST['page']))){
        @$defaults['Orden'] = $_SESSION['Orden'];
    }else{  $defaults = array (	'Nombre' => '',
                                'Apellidos' => '',
                                'Orden' => '`id` ASC');
            $_SESSION['Orden'] = '`id` ASC';
    }

    require 'tabla_errors.php';

    $ordenar = array (	'`id` ASC' => 'ID Ascen',
                        '`id` DESC' => 'ID Descen',
                        '`Nombre` ASC' => 'Nombre Ascen',
                        '`Nombre` DESC' => 'Nombre Descen',
                        '`Apellidos` ASC' => 'Apellido Ascen',
                        '`Apellidos` DESC' => 'Apellido Descen',
                        '`Email` ASC' => 'Email Ascen',
                        '`Email` DESC' => 'Email Descen',);

    if(($_SESSION['Nivel'] == 'admin')){ 

    print(" <table class='centradiv'>
            <tr>
                <th colspan=3>".$titulo."</th>
            </tr>
            <tr>
                <td style='text-align:right !important;'>
            <form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
                    <button type='submit' title='FILTRO' class='botonverde imgButIco BuscaBlack' style='vertical-align:top;' > </button>
                        <input type='hidden' name='ocultoc' value=1 />
                </td>
                <td style='text-align:right !important;'>	
                    NOMBRE
                </td>
                <td style='text-align:left !important;'>
            <input type='text' name='Nombre' size=20 maxlenth=10 value='".@$defaults['Nombre']."' />
                </td>
            </tr>
            <tr>
                <td colspan=2 style='text-align:right !important;'>	
                    APELLIDO
                </td>
                <td style='text-align:left !important;'>
            <input type='text' name='Apellidos' size=20 maxlenth=10 value='".@$defaults['Apellidos']."' />
         </form>	
               </td>
            </tr>
            <tr>
                <td style='text-align:right;'>
        <form name='todo' method='post' action='$_SERVER[PHP_SELF]' >
                    <button type='submit' title='".$boton."' class='botonverde imgButIco PersonsBlack' style='vertical-align:top;' ></button>
                        <input type='hidden' name='todo' value=1 />
                </td>
                <td style='text-align:right !important;'>	
                    ORDEN
                </td>
                <td>
                    <select name='Orden' class='botonverde'>");
                    
            foreach($ordenar as $option => $label){
                print ("<option value='".$option."' ");
                if($option == @$defaults['Orden']){ print ("selected = 'selected'"); }
                                                print ("> $label </option>");
            }

        print ("</select>
            </form>													
                    </td>
                </tr>
        </table>");
                }	// CONDICIONAL NIVEL ADMIN

?>