﻿<?php

	require $rutaindex.'Inclu/mydni.php';
	require $rutaindex.'Inclu/error_hidden.php';
	global $db_name;

	global $topcat0;		global $topcat1;		global $topcat2;
	global $topcat3;		global $topcat4;		global $topcat5;

	if((($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin'))&&($_SESSION['dni'] == $_SESSION['mydni'])) {
		$topcat0 = "style='margin-top:31px'";
		$topcat1 = "style='margin-top:62px'";
		$topcat2 = "style='margin-top:94px'";
		$topcat3 = "style='margin-top:126px'";
		$topcat4 = "style='margin-top:158px'";
		$topcat5 = "style='margin-top:189px'";
	}else{
		$topcat0 = "";
		$topcat1 = "style='margin-top:31px'";
		$topcat2 = "style='margin-top:62px'";
		$topcat3 = "style='margin-top:94px'";
		$topcat4 = "style='margin-top:126px'";
		$topcat5 = "style='margin-top:158px'";

	}


	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')) {	
			global $niv;
			if($_SESSION['dni'] == $_SESSION['mydni']) { $niv = 'Web Master';
			}else{	$niv = 'Administrador'; }
	require $rutaindex.'Inclu_MInd/Master_Index_Header.php';
	
	print("
	<!--
							////////////////////
			////////////////////			////////////////////
							////////////////////

							INICIO NIVEL ADMIN
								
							////////////////////
			////////////////////			////////////////////
							////////////////////
	-->
	<nav class='sidebar-nav'>
		<ul>");

if($_SESSION['dni'] == $_SESSION['mydni']) {
	
	print("<li>
			<a href='#'>
				<i class='ic ico22'></i><span>WEB MASTER</span>
			</a>
				<ul class='nav-flyout'>
					<li>
						<a href='".$rutainclu."empleados.php'>
							<i class='ic ico22'></i>Nª EMPLEADOS
						</a>
					</li>
					<li>
						<a href='".$rutaupbbdd."export_bbdd_backups.php'>
							<i class='ic ico22'></i>BACKUP BBDD
						</a>
					</li>
				</ul>
			</li>");

		require 'index_admin.php';

	}else{

		require 'index_admin.php';

	} // Fin condicional web master
	
	} elseif($_SESSION['Nivel'] == 'plus') {
						
	global $niv;
	$niv = 'Usuario Plus';
	
	require $rutaindex.'Inclu_MInd/Master_Index_Header.php';
		print("<nav class='sidebar-nav'><ul>");
	require 'index_admin.php';

	}elseif($_SESSION['Nivel'] == 'user') {
						
	global $niv;
	$niv = 'Usuario';

	require $rutaindex.'Inclu_MInd/Master_Index_Header.php';
		print("<nav class='sidebar-nav'><ul>");
	require 'index_admin.php';
	} 
	
/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */
?>