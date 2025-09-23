<?php

    /*
        OJO index_Play_System L.774 & 802 FORMULARIO FICHAR ENTRADA
        <input type='hidden' id='myimg' name='myimg' value='".$rp['myimg']."' />
    */

    global $Action;         global $ImgForm;        global $FormButtonHome;

    global $din;            global $tin;
    global $dout;           global $tout;           global $ttot;

    global $name1;          global $name1o;
    if(isset($rp['Nombre'])){ $name1 = $rp['Nombre'];
    }elseif($name1o != ""){ $name1 = $name1o;
    }elseif(isset($_POST['name1'])){ $name1 = $_POST['name1'];
    }elseif(isset($_SESSION['Nombre'])){ $name1 = $_SESSION['Nombre'];
    }else{ $name1 = ""; }

    global $name2;          global $name2o;
    if(isset($rp['Apellidos'])){ $name2 = $rp['Apellidos'];
    }elseif($name2o != ""){ $name2 = $name2o;
    }elseif(isset($_POST['name2'])){ $name2 = $_POST['name2'];
    }elseif(isset($_SESSION['Apellidos'])){ $name2 = $_SESSION['Apellidos'];
    }else{ $name2 = ""; }

    global $RefUser;
    if(isset($rp['ref'])){ $RefUser = $rp['ref'];
    }elseif(isset($_SESSION['usuarios'])){ $RefUser = $_SESSION['usuarios'];
    }elseif(isset($_SESSION['ref'])){ $RefUser = $_SESSION['ref'];
    }else{ $RefUser = ""; }

    global $ImgFormIndex;       global $InputImgIndex;
    if($ImgFormIndex == 1){
        $InputImgIndex = "<input type='hidden' id='myimg' name='myimg' value='".$rp['myimg']."' />";
    }else{
        $InputImgIndex = "";
    }

    global $FichaIn;
    $FichaIn = "<ul class='centradiv'>
                        <li class='liCentra'>FICHE SU ENTRADA</li>
                            ".$ImgForm."
                        <li class='liCentra'>
                            ".strtoupper($name1)." ".strtoupper($name2)."
                        </li>
                        <li class='liCentra'>REFER: ".strtoupper($RefUser)."</li>
                        <li class='liCentra'>
                            ".$FormButtonHome."
                    <form name='form_datos' method='post' ".$Action." style='display:inline-block;'>
                        ".$InputImgIndex."
                        <input type='hidden' id='ref' name='ref' value='".$RefUser."' />
                        <input type='hidden' id='name1' name='name1' value='".$name1."' />
                        <input type='hidden' id='name2' name='name2' value='".$name2."' />
                        <input type='hidden' id='din' name='din' value='".$din."' />
                        <input type='hidden' id='tin' name='tin' value='".$tin."' />
                        <input type='hidden' id='dout' name='dout' value='".$dout."' />
                        <input type='hidden' id='tout' name='tout' value='".$tout."' />
                        <input type='hidden' id='ttot' name='ttot' value='".$ttot."' />
                            <button type='submit' title='FICHAR ENTRADA' class='botonverde imgButIco Clock1Black' style='vertical-align:top;' ></button>
                        <input type='hidden' name='entrada' value=1 />
                    </form>														
                        </li>
                </ul>".$rutaAudio; 

    global $FichaOut;
    $FichaOut = "<ul class='centradiv'>
                        <li class='liCentra'>FICHE SU SALIDA</li>
                            ".$ImgForm."
                        <li class='liCentra'>
                            ".strtoupper($name1)." ".strtoupper($name2)."
                        </li>
                        <li class='liCentra'>REFER: ".strtoupper($RefUser)."</li>
                        <li class='liCentra'>
                            ".$FormButtonHome."
                    <form name='form_datos' method='post' ".$Action." style='display: inline-block;'>
                        ".$InputImgIndex."
                        <input type='hidden' id='ref' name='ref' value='".$RefUser."' />
                        <input type='hidden' id='name1' name='name1' value='".$name1."' />
                        <input type='hidden' id='name2' name='name2' value='".$name2."' />
                        <input type='hidden' id='dout' name='dout' value='".$dout."' />
                        <input type='hidden' id='tout' name='tout' value='".$tout."' />
                            <button type='submit' title='FICHAR SALIDA' class='botonnaranja imgButIco Clock1Black' style='vertical-align:top;' ></button>
                            <input type='hidden' name='salida' value=1 />
                    </form>														
                        </li>
                </ul>".$rutaAudio; 


?>