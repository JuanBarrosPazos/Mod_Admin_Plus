<?php

	global $db;				global $qb;			global $dyt1;
    global $name1;			global $name2;		global $colspana;
    global $refses;			global $nodata;		global $feedtot;
	global $totaltime, $totaltime1, $totaltime2, $totaltime3, $totaltime4, $totaltime5, $totaltime6, $totaltime7, $totaltime8, $totaltime9, $totaltime10, $totaltime11, $totaltime12;


	if(!$qb){
		print("ERROR SQL ".mysqli_error($db)."</br>");
	}else{
		global $twhile;			global $tdplus;			global $pdm;
		if(mysqli_num_rows($qb) == 0){
			print ("<div class='centradiv alertdiv'>
						".$nodata."
					</div>");
		}else{
			if(($_POST['dm'] != '')||($pdm == "pdm")){

				if($_POST['dm'] != ''){ botones(); }else{ }

					print ("<table class='centradiv'>
								".$twhile."
							<tr>
								<td class='BorderInfDch'>ID</td>		
								<td class='BorderInfDch'>DATE IN</td>		
								<td class='BorderInfDch'>TIME IN</td>		
								<td class='BorderInfDch'>DATE OUT</td>										
								<td class='BorderInfDch'>TIME OUT</td>
								<td class='BorderInfDch'>TIME TOT</td>
								".$tdplus."
							</tr>");

				while($rowb = mysqli_fetch_assoc($qb)){

					global $sty;		
					if($rowb['errorhourstot'] == "true"){ $sty = "style=\"color: #F1BD2D; font-weight: bold;\"";
					}else{ $sty = ""; }

					global $vname;				global $dyt1;
					global $formularioh;		global $formulariof;
					global $colspana;			global $colspanb;

					print("<tr>".$formularioh."
								<td class='BorderInfDch' ".$sty.">
							<input type='hidden' id='dyt1' name='dyt1' value='".$dyt1."' />
							<input type='hidden' id='ref' name='ref' value='".$refses."' />
							<input type='hidden' id='name1' name='name1' value='".$rowb['Nombre']."' />
							<input type='hidden' id='name2' name='name2' value='".$rowb['Apellidos']."' />
							<input type='hidden' name='id' value='".$rowb['id']."' />".$rowb['id']."
								</td>
								<td class='BorderInfDch' align='left' ".$sty.">
							<input type='hidden' name='datein' value='".$rowb['datein']."' />".$rowb['datein']."
								</td>
								<td class='BorderInfDch' align='right' ".$sty.">
							<input type='hidden' name='timein' value='".$rowb['timein']."' />".$rowb['timein']."
								</td>
								<td class='BorderInfDch' align='right' ".$sty.">
							<input type='hidden' name='dateout' value='".$rowb['dateout']."' />".$rowb['dateout']."
								</td>
								<td class='BorderInfDch' align='right' ".$sty.">
							<input type='hidden' name='timeout' value='".$rowb['timeout']."' />".$rowb['timeout']."
								</td>
								<td class='BorderInfDch' align='right' ".$sty.">
							<input type='hidden' name='hourstot' value='".$rowb['hourstot']."' />".$rowb['hourstot']."
								</td>");

						if(@$rowb['deldate'] != ''){
							print("<td class='BorderInfDch' align='right'>
										<input type='hidden' name='deldate' value='".$rowb['deldate']."' />
											".$rowb['deldate']." / ".$rowb['deltime']."
										<input type='hidden' name='deltime' value='".$rowb['deltime']."' />
									</td>");
						}else{ }

					print($formulariof."</tr>");
					
				} /* FIN del while.*/

			}elseif($_POST['dm'] == ''){
			
				botones();

				print ("<table class='centradiv balresult'>
						<tr>
							<td colspan=".$colspana.">
								".$name1." ".$name2." Ref: ".$refses."
							</td>
						</tr>
						<tr>
							<td colspan=".$colspana.">
								".$dyt1." TOTALES ANUALES
							</td>
						</tr>
						<tr>
							<td>ENERO: </td>
							<td>".$totaltime1."</td>
							<td>FEBRERO: </td>
							<td>".$totaltime2."</td>
							<td>MARZO: </td>
							<td>".$totaltime3."</td>
						</tr>
						<tr>
							<td>ABRIL: </td>
							<td>".$totaltime4."</td>
							<td>MAYO: </td>
							<td>".$totaltime5."</td>
							<td>JUNIO: </td>
							<td>".$totaltime6."</td>
						</tr>
						<tr>
							<td>JULIO: </td>
							<td>".$totaltime7."</td>
							<td>AGOSTO: </td>
							<td>".$totaltime8."</td>
							<td>SEPTIEMBRE: </td>
							<td>".$totaltime9."</td>
						</tr>
						<tr>
							<td>OCTUBRE: </td>
							<td>".$totaltime10."</td>
							<td>NOVIEMBRE: </td>
							<td>".$totaltime11."</td>
							<td>DICIEMBRE: </td>
							<td>".$totaltime12."</td>
						</tr>");
			} // FIN elseif($_POST['dm'] == '')

			if($feedtot == "nofeed"){
			}else{ print("<tr>
								<td colspan='".$colspana."'></td>
							</tr>
							<tr>
								<td colspan='".$colspana."'>".$totaltime."</td>
							</tr>");
			}
			print("</table>");

			if($_POST['dm'] == ''){
				require 'graficasInit/graficaIndex.php';
				require 'graficasInit/calc_anu.php';
			}else{ }

			if(($_POST['dy']=='')&&($_POST['dm']=='')){
					//require 'graficasInit/calc_anu.php';
			}else{ }
		
	} /* FIN segundo else anidado en if */

} /* FIN de primer else . */

?>