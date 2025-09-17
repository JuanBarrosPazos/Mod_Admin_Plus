<?php

    global $name1;		global $name2;		global $refses;		global $TablaTitulo;

	if(!$qb){
		print("ERROR SQL ".mysqli_error($db)."</br>");
	}else{
		if(mysqli_num_rows($qb) == 0){
			print ("<div class='centradiv alertdiv'>NO HAY DATOS</div>");
	}else{ 

		if(($_POST['dd']=="")&&(!isset($_POST['cherror'])&&(!isset($_POST['chbin'])))){
			print ("<div class='centradiv alertdiv'>
						".$name1." ".$name2." Ref: ".$refses."<br>
						".$dyt1." TOTALES CONSULTA<br>
						".$sumatodo."
					</div>");
		}

		print ("<table class='centradiv'>
					<tr>
						<td colspan=7 style='color:#F1BD2D;'>
							".$TablaTitulo.$name1." ".$name2.". Ref: ".$refses."
						</td>
					</tr>
					<tr>
						<td>ID</td>			<td>DATE IN</td>		
						<td>TIME IN</td>	<td>DATE OUT</td>										
						<td>TIME OUT</td>	<td>TIME TOT</td>
						<td></td>
					</tr>");
		
		global $action1;	global $action2;	global $botonTit1;		global $botonTit2;
		if((isset($_POST['chbin']))&&(!isset($_POST['cherror']))){
			$action1 = "Reg_Fichar_Bin_Recuperar.php";
			$botonTit1 = "RECUPERAR REGISTRO";
			$action2 = "Reg_Fichar_Bin_Borrar.php";
			$botonTit2 = "BORRAR PAPELERA";
		}else{
			$action1 = "Reg_Fichar_Modificar.php";
			$botonTit1 = "MODIFICAR REGISTROS";
			$action2 = "Reg_Fichar_Borrar.php";
			$botonTit2 = "BORRAR DATOS";
		}
		
		$countbgc = 0;
		while($rowb = mysqli_fetch_assoc($qb)){
			global $sty;
			if($rowb['ttot'] == "00:00:01"){ 
					$sty = "color: #F1BD2D; font-weight: bold;";
			}else{ $sty = ""; }

			if(($countbgc%2)==0){
					$bgcolor ="background-color:#59746A;";
			}else{ 	$bgcolor =""; }

			global $vname;				global $dyt1;

			print ("<tr>
					<td align='center' style='".$sty.$bgcolor."'>
			<form name='modifica' action='".$action1."' method='POST' style='display:inline-block;'>
					".$rowb['id']."
					</td>
					<td style='".$sty.$bgcolor."'>".$rowb['din']."</td>
					<td style='".$sty.$bgcolor."'>".$rowb['tin']."</td>
					<td style='".$sty.$bgcolor."'>".$rowb['dout']."</td>
					<td style='".$sty.$bgcolor."'>".$rowb['tout']."</td>
					<td style='".$sty.$bgcolor."'>".$rowb['ttot']."</td>
					<td style='".$sty.$bgcolor."'>");

			require 'Inc_Input_Row_Total.php';

			print("<button type='submit' title='".$botonTit1."' class='botonverde imgButIco Clock2Black' style='vertical-align:middle;' ></button>
				</form>

			<form name='modifica' action='".$action2."' method='POST' style='display:inline-block;'>");

			require 'Inc_Input_Row_Total.php';

			print("<button type='submit' title='".$botonTit2."' class='botonrojo imgButIco DeleteBlack' style='vertical-align:middle;' ></button>
				</form>
					</td>
				</tr>");
				
			$countbgc = $countbgc+1;

		} /* FIN del while.*/

		print "</table>";

	} /* FIN segundo else anidado en if */
} /* FIN de primer else . */

?>