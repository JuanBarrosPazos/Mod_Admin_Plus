<?php

    global $name1;			global $name2;
    global $refses;			global $nodata;

	if(!$qb){
		print("ERROR SQL ".mysqli_error($db)."</br>");
			
	}else{

		global $twhile;			global $tdplus;			global $pdm;
		if(mysqli_num_rows($qb) == 0){
			print ("<div class='centradiv' style='border-color:#F1BD2D; color:#F1BD2D;'>
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
					if($rowb['ttot'] == "68:68:68"){ $sty = "style=\"color: #F1BD2D; font-weight: bold;\"";
					}else{ $sty = ""; }

					global $vname;				global $dyt1;
					global $formularioh;		global $formulariof;
					global $colspana;			global $colspanb;

					print("<tr align='center'>".$formularioh."
								<td class='BorderInfDch' align='center' ".$sty.">
							<input type='hidden' id='dyt1' name='dyt1' value='".$dyt1."' />
							<input type='hidden' id='ref' name='ref' value='".$refses."' />
							<input type='hidden' id='name1' name='name1' value='".$rowb['Nombre']."' />
							<input type='hidden' id='name2' name='name2' value='".$rowb['Apellidos']."' />
							<input type='hidden' name='id' value='".$rowb['id']."' />".$rowb['id']."
								</td>
								<td class='BorderInfDch' align='left' ".$sty.">
							<input type='hidden' name='din' value='".$rowb['din']."' />".$rowb['din']."
								</td>
								<td class='BorderInfDch' align='right' ".$sty.">
							<input type='hidden' name='tin' value='".$rowb['tin']."' />".$rowb['tin']."
								</td>
								<td class='BorderInfDch' align='right' ".$sty.">
							<input type='hidden' name='dout' value='".$rowb['dout']."' />".$rowb['dout']."
								</td>
								<td class='BorderInfDch' align='right' ".$sty.">
							<input type='hidden' name='tout' value='".$rowb['tout']."' />".$rowb['tout']."
								</td>
								<td class='BorderInfDch' align='right' ".$sty.">
							<input type='hidden' name='ttot' value='".$rowb['ttot']."' />".$rowb['ttot']."
								</td>");

						if(@$rowb['dfeed'] != ''){
							print("<td class='BorderInfDch' align='right'>
										<input type='hidden' name='dfeed' value='".$rowb['dfeed']."' />
											".$rowb['dfeed']." / ".$rowb['tfeed']."
										<input type='hidden' name='tfeed' value='".$rowb['tfeed']."' />
									</td>");
						}else{ }

					print($formulariof."</tr>");
					
				} /* FIN del while.*/

			}elseif($_POST['dm'] == ''){
			
			botones();

			print ("<table class='centradiv balresult'>
					<tr>
						<th colspan=".$colspana.">
							".$name1." ".$name2." Ref: ".$refses."
						</th>
					</tr>
					<tr>
						<th colspan=".$colspana.">
							".$dyt1." TOTALES ANUALES
						</th>
					</tr>
					<tr>
						<td style='text-align:right !important;'>ENERO: </td>
						<td style='text-align:left !important;'>".$totaltime1."</td>
						<td style='text-align:right !important;'>FEBRERO: </td>
						<td style='text-align:left !important;'>".$totaltime2."</td>
						<td style='text-align:right !important;'>MARZO: </td>
						<td style='text-align:left !important;'>".$totaltime3."</td>
					</tr>
					<tr>
						<td style='text-align:right !important;'>ABRIL: </td>
						<td style='text-align:left !important;'>".$totaltime4."</td>
						<td style='text-align:right !important;'>MAYO: </td>
						<td style='text-align:left !important;'>".$totaltime5."</td>
						<td style='text-align:right !important;'>JUNIO: </td>
						<td style='text-align:left !important;'>".$totaltime6."</td>
					</tr>
					<tr>
						<td style='text-align:right !important;'>JULIO: </td>
						<td style='text-align:left !important;'>".$totaltime7."</td>
						<td style='text-align:right !important;'>AGOSTO: </td>
						<td style='text-align:left !important;'>".$totaltime8."</td>
						<td style='text-align:right !important;'>SEPTIEMBRE: </td>
						<td style='text-align:left !important;'>".$totaltime9."</td>
					</tr>
					<tr>
						<td style='text-align:right !important;'>OCTUBRE: </td>
						<td style='text-align:left !important;'>".$totaltime10."</td>
						<td style='text-align:right !important;'>NOVIEMBRE: </td>
						<td style='text-align:left !important;'>".$totaltime11."</td>
						<td style='text-align:right !important;'>DICIEMBRE: </td>
						<td style='text-align:left !important;'>".$totaltime12."</td>
					</tr>");
		} // FIN elseif($_POST['dm'] == '')

		if($feedtot == "nofeed"){
		}else{ print("<tr>
							<td colspan='".$colspana."'></td>
						</tr>
						<tr>
							<td colspan='2' align='right'>TOTALES</td>
							<td colspan='".$colspanb."' align='left'>".$totaltime."</td>
						</tr>");
		}
		print("</table>");


		if($_POST['dm'] == ''){
			require 'graficasIndex/graficaIndex.php';
		}else{ }
		
	} /* FIN segundo else anidado en if */


} /* FIN de primer else . */

?>