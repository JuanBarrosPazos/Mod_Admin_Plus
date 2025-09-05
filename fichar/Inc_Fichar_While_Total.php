<?php

    global $name1;
    global $name2;
    global $refses;
    global $nodata;

	if(!$qb){
	print("<font color='#FF0000'>Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
			
	}else{
		if(mysqli_num_rows($qb) == 0){
			print ("<table align='center'>
						<tr>
							<td>
								<font color='#FF0000'>".$nodata."</font>
							</td>
						</tr>
					</table>");
	}else{ 

    global $twhile;
    global $tdplus;
    global $pdm;

    if((isset($_POST['dm']) != '')||($pdm == "pdm")){
    print ("<table align='center'>
					".$twhile."
									
				<tr>
					<th class='BorderInfDch'>
							ID
					</th>		
										
					<th class='BorderInfDch'>
							DATE IN
					</th>		
										
					<th class='BorderInfDch'>
							TIME IN
					</th>		
									
					<th class='BorderInfDch'>
							DATE OUT
					</th>										

					<th class='BorderInfDch'>
							TIME OUT
					</th>
										
					<th class='BorderInfDch'>
							TIME TOT
					</th>
							".$tdplus."
				</tr>");
			
	while($rowb = mysqli_fetch_assoc($qb)){

		if($rowb['ttot'] == "68:68:68"){ 
				global $sty;
				$sty = "style=\"color: #FF0000; font-weight: bold;\"";}
			else{ global $sty;
				  $sty = "";}

    global $vname;
    global $dyt1;
    global $formularioh;
    global $formulariof;
	global $colspana;
	global $colspanb;

	print (	"<tr align='center'>".$formularioh."

            <input name='dyt1' type='hidden' value='".$dyt1."' />
            <input type='hidden' id='ref' name='ref' value='".$refses."' />
            <input type='hidden' id='name1' name='name1' value='".$rowb['Nombre']."' />
            <input type='hidden' id='name2' name='name2' value='".$rowb['Apellidos']."' />

                <td class='BorderInfDch' align='center' ".$sty.">
            <input name='id' type='hidden' value='".$rowb['id']."' />".$rowb['id']."
                </td>

				<td class='BorderInfDch' align='left' ".$sty.">
			<input name='din' type='hidden' value='".$rowb['din']."' />".$rowb['din']."
				</td>
						
				<td class='BorderInfDch' align='right' ".$sty.">
			<input name='tin' type='hidden' value='".$rowb['tin']."' />".$rowb['tin']."
				</td>
						
				<td class='BorderInfDch' align='right' ".$sty.">
			<input name='dout' type='hidden' value='".$rowb['dout']."' />".$rowb['dout']."
				</td>

				<td class='BorderInfDch' align='right' ".$sty.">
			<input name='tout' type='hidden' value='".$rowb['tout']."' />".$rowb['tout']."
				</td>

				<td class='BorderInfDch' align='right' ".$sty.">
			<input name='ttot' type='hidden' value='".$rowb['ttot']."' />".$rowb['ttot']."
				</td>
						".$formulariof."
			</tr>");
        } /* Fin del while.*/ 
    }

    elseif($_POST['dm'] == ''){
        print ("<table align='center'>
                    <tr>
                        <th colspan=".$colspana." class='BorderInf'>
                            ".$name1." ".$name2." Ref: ".$refses.".
                        </th>
                   </tr>
                   <tr>
                        <th colspan=".$colspana." class='BorderInf'>
                            ".$dyt1." TOTALES ANUALES.
                        </th>
                    </tr>");
                }
	
	if($feedtot == "nofeed"){}
	else{
	print("	<tr>
				<td colspan='".$colspana."' class='BorderInf'>
				</td>
			</tr>
						
			<tr>
				<td colspan='2' class='BorderInf' align='right'>
						TOTALES:
				</td>
				<td colspan='".$colspanb."' class='BorderInf' align='left'>
						".$sumatodo."
				</td>
			</tr>");
			}
	print("</table>");
		
		} /* Fin segundo else anidado en if */
	} /* Fin de primer else . */

?>