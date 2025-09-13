<?php
	
	////////////////////		***********  		////////////////////
                        /*  TABLA BALANCE MENSUAL  */
	////////////////////		***********  		////////////////////

		print ("<div style='clear:both'></div>
				<div class='section centradiv ocultagraf' style='padding: 0.6em 0.2em 1.2em 0.2em;'>
					GRAFICA HORAS MENSUALES ".$dyt1."
					<ul class='timeline'>");
			  
			global $totaltime0; 	$totaltime0 = $horas.".".$minutos;
			//echo $totaltime0;

			global $totaltime1;
			$totaltime1 = number_format($totaltime1 ,2,".","");
			if($totaltime1 > 0){
				$TotM1 = ($totaltime1*100)/$totaltime0;
				$li1 = "<li>
						<a href='#' title='ENERO ".$dyt1." ".(abs($totaltime1))." Hr'>
							<span class='label'>ENE<br>".(abs($totaltime1))."</span>
							<span class='count bgcolori' style='height: ".$TotM1."%'>(".$TotM1.")</span>
						</a>
					</li>";
			}else{ $TotM1 = 0.00; $li1 = ""; }

			global $totaltime2;
			$totaltime2 = number_format($totaltime2 ,2,".","");
			if($totaltime2 > 0){
				$TotM2 = ($totaltime2*100)/$totaltime0;
				$li2 = "<li>
						<a href='#' title='FEBRERO ".$dyt1." ".(abs($totaltime2))." Hr'>
							<span class='label'>FEB<br>".(abs($totaltime2))."</span>
							<span class='count bgcolori' style='height: ".$TotM2."%'>(".$TotM2.")</span>
						</a>
					</li>";
			}else{ $TotM2 = 0.00; $li2 = ""; }

			global $totaltime3;
			$totaltime3 = number_format($totaltime3 ,2,".","");
			if($totaltime3 > 0){
				$TotM3 = ($totaltime3*100)/$totaltime0;
				$li3 ="<li>
						<a href='#' title='MARZO ".$dyt1." ".(abs($totaltime3))." Hr'>
							<span class='label'>MAR<br>".(abs($totaltime3))."</span>
							<span class='count bgcolori' style='height: ".$TotM3."%'>(".$TotM3.")</span>
						</a>
					</li>";
			}else{ $TotM3 = 0.00; $li3 = ""; }

			global $totaltime4;
			$totaltime4 = number_format($totaltime4 ,2,".","");
			if($totaltime4 > 0){
				$TotM4 = ($totaltime4*100)/$totaltime0;
				$li4 = "<li>
						<a href='#' title='ABRIL ".$dyt1." ".(abs($totaltime4))." Hr'>
							<span class='label'>ABR<br>".(abs($totaltime4))."</span>
							<span class='count bgcolori' style='height: ".$TotM4."%'>(".$TotM4.")</span>
						</a>
					</li>";
			}else{ $TotM4 = 0.00; $li4 = ""; }

			global $totaltime5;
			$totaltime5 = number_format($totaltime5 ,2,".","");
			if($totaltime5 > 0){
				$TotM5 = ($totaltime5*100)/$totaltime0;
				$li5 = "<li>
						<a href='#' title='MAYO ".$dyt1." ".(abs($totaltime5))." Hr'>
							<span class='label'>MAY<br>".(abs($totaltime5))."</span>
							<span class='count bgcolori' style='height: ".$TotM5."%'>(".$TotM5.")</span>
						</a>
					</li>";
			}else{ $TotM5 = 0.00; $li5 = ""; }

			global $totaltime6;
			$totaltime6 = number_format($totaltime6 ,2,".","");
			if($totaltime6 > 0){
				$TotM6 = ($totaltime6*100)/$totaltime0;
				$li6 = "<li>
						<a href='#' title='JUNIO ".$dyt1." ".(abs($totaltime6))." Hr'>
							<span class='label'>JUN<br>".(abs($totaltime6))."</span>
							<span class='count bgcolori' style='height: ".$TotM6."%'>(".$TotM6.")</span>
						</a>
					</li>";
			}else{ $TotM6 = 0.00; $li6 = ""; }

			global $totaltime7;
			$totaltime7 = number_format($totaltime7 ,2,".","");
			if($totaltime7 > 0){
				$TotM7 = ($totaltime7*100)/$totaltime0;
				$li7 = "<li>
						<a href='#' title='JULIO ".$dyt1." ".(abs($totaltime7))." Hr'>
							<span class='label'>JUL<br>".(abs($totaltime7))."</span>
							<span class='count bgcolori' style='height: ".$TotM7."%'>(".$TotM7.")</span>
						</a>
					</li>";
			}else{ $TotM7 = 0.00; $li7 = ""; }

			global $totaltime8;
			$totaltime8 = number_format($totaltime8 ,2,".","");
			if($totaltime8 > 0){
				$TotM8 = ($totaltime8*100)/$totaltime0;
				$li8 = "<li>
						<a href='#' title='AGOSTO ".$dyt1." ".(abs($totaltime8))." Hr'>
							<span class='label'>AGO<br>".(abs($totaltime8))."</span>
							<span class='count bgcolori' style='height: ".$TotM8."%'>(".$TotM8.")</span>
						</a>
					</li>";
			}else{ $TotM8 = 0.00; $li8 = ""; }

			global $totaltime9;
			$totaltime9 = number_format($totaltime9 ,2,".","");
			if($totaltime9 > 0){
				$TotM9 = ($totaltime9*100)/$totaltime0;
				$li9 = "<li>
						<a href='#' title='SEPTIEMBRE ".$dyt1." ".(abs($totaltime9))." Hr'>
							<span class='label'>SEP<br>".(abs($totaltime9))."</span>
							<span class='count bgcolori' style='height: ".$TotM9."%'>(".$TotM9.")</span>
						</a>
					</li>";
			}else{ $TotM9 = 0.00; $li9 = ""; }

			global $totaltime10;
			$totaltime10 = number_format($totaltime10 ,2,".","");
			if($totaltime10 > 0){
				$TotM10 = ($totaltime10*100)/$totaltime0;
				$li10 = "<li>
						<a href='#' title='OCTUBRE ".$dyt1." ".(abs($totaltime10))." Hr'>
							<span class='label'>OCT<br>".(abs($totaltime10))."</span>
							<span class='count bgcolori' style='height: ".$TotM10."%'>(".$TotM10.")</span>
						</a>
					</li>";
			}else{ $TotM10 = 0.00; $li10 = ""; }

			global $totaltime11;
			$totaltime11 = number_format($totaltime11 ,2,".","");
			if($totaltime11 > 0){
				$TotM11 = ($totaltime11*100)/$totaltime0;
				$li11 = "<li>
						<a href='#' title='NOVIEMBRE ".$dyt1." ".(abs($totaltime11))." Hr'>
							<span class='label'>NOV<br>".(abs($totaltime11))."</span>
							<span class='count bgcolori' style='height: ".$TotM11."%'>(".$TotM11.")</span>
						</a>
					</li>";
			}else{ $TotM11 = 0.00; $li11 = ""; }

			global $totaltime12;
			$totaltime12 = number_format($totaltime12 ,2,".","");
			if($totaltime12 > 0){
				$TotM12 = ($totaltime12*100)/$totaltime0;
				$li12 = "<li>
						<a href='#' title='DICIEMBRE ".$dyt1." ".(abs($totaltime12))." Hr'>
							<span class='label'>DIC<br>".(abs($totaltime12))."</span>
							<span class='count bgcolori' style='height: ".$TotM12."%'>(".$TotM12.")</span>
						</a>
					</li>";
			}else{ $TotM12 = 0.00; $li12 = ""; }

			print($li1.$li2.$li3.$li4.$li5.$li6.$li7.$li8.$li9.$li10.$li11.$li12);


		if($totaltime0 > 0){
				$TotEi = ((abs($totaltime0))*100)/(abs($totaltime0));
		}else{ 	$TotEi = 0.00; }

		print("<!--	-->
					<li>
						<a href='#' title='ANUAL TOT ".(abs($totaltime0))." Hr'>
							<span class='label'>".$dyt1."<br>".(abs($totaltime0))."</span>
							<span class='count bgcolord' style='height: ".$TotEi."%'>(".$TotEi.")</span>
						</a>
					</li>
				</ul>
				</div>");




?>