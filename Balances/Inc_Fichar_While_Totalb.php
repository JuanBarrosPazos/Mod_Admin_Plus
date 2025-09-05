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

    if(($_POST['dm'] != '')||($pdm == "pdm")){

		if($_POST['dm'] != ''){ botones(); }else{ }

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
				global $sty;	$sty = "style=\"color: #FF0000; font-weight: bold;\"";

		}else{ 	global $sty;	$sty = ""; }

    global $vname;				global $dyt1;
    global $formularioh;		global $formulariof;
	global $colspana;			global $colspanb;

	print (	"<tr align='center'>".$formularioh."
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
			print("
				<td class='BorderInfDch' align='right'>
						<input type='hidden' name='dfeed' value='".$rowb['dfeed']."' />
						".$rowb['dfeed']." / ".$rowb['tfeed']."
						<input type='hidden' name='tfeed' value='".$rowb['tfeed']."' />
				</td>");
			}else{ }

			print($formulariof."</tr>");
			
        } /* Fin del while.*/

    }elseif($_POST['dm'] == ''){
		
		botones();

        print ("<table class='TFormAdmin'>
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
	
	if($feedtot == "nofeed"){
	}else{
	print("	<tr>
				<td colspan='".$colspana."' class='BorderInf'></td>
			</tr>
			<tr>
				<td colspan='2' class='BorderInf' align='right'>
						TOTALES:
				</td>
				<td colspan='".$colspanb."' class='BorderInf' align='left'>
						".$totaltime."
				</td>
			</tr>");
	}
	print("</table>");
		
		} /* Fin segundo else anidado en if */
	} /* Fin de primer else . */

?>