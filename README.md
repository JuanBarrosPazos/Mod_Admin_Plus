## © Juan M. Barrós Pazos. Bajo Licencia CC BY-NC-SA.

### Reconocimiento: © Juan M. Barrós Pazos.
### Contacto: juanbarrospazos@hotmail.es
## Licencia CC BY-NC-SA.
    Creative Commons Reconocimiento-NoComercial-CompartirIgual (CC BY-NC-SA).
    Esta licencia permite copiar, distribuir y modificar una obra (copyleft), pero exige que se reconozca la autoría (CC BY), que el uso no sea comercial (NC), y que cualquier obra derivada se comparta bajo la misma licencia o una compatible (SA).
### DESCARGA DE RESPONSABILIDADES:
  	Juan M. Barrós Pazos, no se hace responsable, en ningún caso, del uso de esta aplicación y de los daños o perjuicios ocasionados, en cualquiera de sus formas.
    Por el uso de la misma, tal y como se presenta en el repositorio, o por la modificación y distribución de la misma por terceros.

----
## CUESTIONES PENDIENTES...
#### Limitar el número de WebMaster permitidos a x...
#### Audio error fichar pin desde pantalla bloqueo ip/Mac...
#### Audio usuario locked...
#### Optimizar tablas Admin resultados y formularios...
#### input text en formularios de filtro en fichar/
#### Modificar el contenido de los mensajes en los log de actividad de los Admin...
#### Confirmar mensajes: print("ERROR SQL L.xxx: ".mysqli_error($db));
----
## ULTIMAS MODIFICACIONES.
#### Mod_Admin_Plus V25.10.05 2025/10/05
	- Se modifica el array nivel usuarios y el modo de crear WebMaster...
	- Se crea el nivel de usuario wmaster para $_SESSION['Nivel']...
	- Se modifica todo el código relacionado con Inclu/webmaster.php y $_SESSION['webmaster']...
	- Se realiza una instalación desde cero...
	- Ok Validación Formulario Instalación...
	- Ok Creación del archivo de conexiones Conections/conection.php
	- Ok Creación de las tablas de sistema en bbdd...
	- Ok Creación de usuario WebMaster, datos en tabla admin y tablas de usuario en bbdd.
	- Ok Creación directorio usuario WebMaster en el servidor Users/xxxx/...
	- Ok Sustitución de index.php de instalación por config/index_Play_System.php y cambion de nombre.
	- Ok Fichar con pin desde index.php, funciones y datos en tabla usuario, y redirección...
	- Ok Fichar con pin desde index.php pantalla bloqueo ip/Mac...
	- Ok He perdido mis claves...
	- Ok Bloqueo de ip/Mac...
	- Ok Desbloqueo de ip/Mac con formulario de usuario...
	- Ok Redireccionamiento auto index.php?redirIpBlock=1...
	- Ok Desbloquio automático de ip/Mac con redireccionamiento window.location.href='index.php?redirIpBlock=1';
	- Ok Se modifica el redireccinamiento de bloqueo de ip/Mac: setTimeout('redir()',60000); a 120000 (2min)
	- Ok Suma visitas al index.php, accesos autorizados y denegados.
	- Ok Inicio y cierre de sesión de WebMaster, y datos en tabla admin...
	- Ok Menú funciones Webmaster...
	- Ok Ver detalles del usuario WebMaster...
	- Ok Modificar imagen y datos Webmaster, y validación...
	- Ok Inclu/empleados.php modificar número de empleados permitidos...
	- Ok Inclu/empleados.php validación y restricción al crear empleados, sin contar los webmaster...
	- Ok upbbdd/export_bbdd_backups.php Exportación manual de la bbdd al servidor...
	- Ok upbbdd/export_bbdd_backups.php Exportación al cliente...
	- Ok upbbdd/export_bbdd_backups.php Borrado de archivos sql en el servidor...
	- Ok Creación de nuevo usuario, datos en bbdd y directorio de usuario en servidor...
	- Ok ver detalles nuevo usuario...
	- Ok modificar imagen y datos del nuevo usuario, y validación...
	- Ok cierre automático de ventanas popup...
	- Ok Formulario filtro usuarios Admin/Admin_Ver.php...
	- Ok Navegación botonera Admin...
	- Ok Paginación usuarios...
	- Ok Borrar usuario y recuperar usuario, ver detalles usuario en papelera...
	- Ok Eliminar usuario del sistema, eliminado de papelerea y archivos en el servidor...
	- Ok Fichar entrada con sesión abierta...
	- Ok Qr User Code Crear, Descargar y eliminar...
	- Ok Inicio sesión distintos niveles usuario y bloqueo de usuario...
----
#### Mod_Admin_Plus V25.10.04 2025/10/04
	- Optimizar menu para @media screen and (max-width:440px){ }
----
#### Mod_Admin_Plus V25.10.03B 2025/10/03
	- Se modifican los terminos de la licencia, DESCARGO DE RESPONSABILIDADES...
	- Se realizan los ajustes necesarios para el bloqueo y desbloqueo con MAC e IP.
	- Redireccionamiento con bloqueo cada minuto...
	- Inclu/Mac_Cliente.php Implementación de script para conocer la MAC del Servidor y del Cliente...

		function GetMacAdd(){
			global $GetMacAdd;
			$strGetMacAdd = exec('getmac');
			$strGetMacAdd = str_replace(' ', '', $strGetMacAdd);
			switch (true) {
				case (($strGetMacAdd!='')&&(!empty($strGetMacAdd))):
					$GetMacAdd = substr($strGetMacAdd, 0, 17);
					break;
				case (($strGetMacAdd=='')||(empty($strGetMacAdd))):
					ob_start();
					system('getmac');
					$SystemGetMac = ob_get_contents();
					ob_clean();
					$GetMacAdd = substr($SystemGetMac, strpos($SystemGetMac,'\\')-20, 17);
					break;
				default:
					$GetMacAdd = "";
					break;
			}
			return $GetMacAdd;
		}

	- Inclu/ipCliente.php Se integra la Mac como identificador para el bloqueo o la ip cliente...
	- ANTERIORMENTE: 	- Eliminación de la librería geoclass...
						- Sustitución de geoplugin.class.php $geoplugin->ip por Inclu/ipCliente.php
		
		global $GetMacAdd;
		// Utilizo $_SESSION['GetMacAdd'] para llamar GetMacAdd solo una vez...
		if((!isset($_SESSION['GetMacAdd'])||($_SESSION['GetMacAdd']==''))){
			GetMacAdd();
			//echo $GetMacAdd."<br>";
			$_SESSION['GetMacAdd'] = $GetMacAdd;
		}else{ }

		global $ipCliente;
		switch (true) {
			case (isset($_SESSION['GetMacAdd'])):
				$ipCliente = $_SESSION['GetMacAdd'];
				break;
			case (($GetMacAdd != "")&&(!empty($GetMacAdd))):
				// Pasamos la MAC del cliente como identificador...
				$ipCliente = $GetMacAdd;
				break;
			case (!empty($_SERVER['HTTP_CLIENT_IP'])):
				$ipCliente = $_SERVER['HTTP_CLIENT_IP'];
				break;
			case ($_SERVER['REMOTE_ADDR'] == getenv("REMOTE_ADDR")):
				$ipCliente = $_SERVER['REMOTE_ADDR'];
				break;
			case (!empty(getenv("REMOTE_ADDR"))):
				$ipCliente = getenv("REMOTE_ADDR");
				break;
			case (!empty($_SERVER['REMOTE_ADDR'])):
				$ipCliente = $_SERVER['REMOTE_ADDR'];
				break;
			case (getenv($_SERVER['HTTP_X-FORWARDED_FOR'])):
				$ipCliente = $_SERVER['HTTP_X-FORWARDED_FOR'];
				break;
			case (getenv($_SERVER['HTTP_X_FORWARDED'])):
				$ipCliente = $_SERVER['HTTP_X_FORWARDED'];
				break;
			case (getenv($_SERVER['HTTP_FORWARDED_FOR'])):
				$ipCliente = $_SERVER['HTTP_FORWARDED_FOR'];
				break;
			case (getenv($_SERVER['HTTP_FORWARDED'])):
				$ipCliente = $_SERVER['HTTP_FORWARDED'];
				break;
			default:
				echo "** NO SE DETECTA LA IP DEL CLIENTE<br>";
				$ipCliente = "10.0.0.0";
				break;
		} // FIN swhitch

----
#### Mod_Admin_Plus V25.09.23 2025/09/23
	- Optimizar Formularios Confirme Fichar...
----
#### Mod_Admin_Plus V25.09.22 2025/09/22
	- Ajustes generales en funciones Fichar...
	- Sustitución del if else por switch case para detección de ip cliente...
	- ANTERIORMENTE: 	- Eliminación de la librería geoclass...
						- Sustitución de geoplugin.class.php $geoplugin->ip por Inclu/ipCliente.php
		global $ipCliente;
		switch (true) {
			case (!empty($_SERVER['HTTP_CLIENT_IP'])):
				$ipCliente = $_SERVER['HTTP_CLIENT_IP'];
				break;
				.....
		} // FIN swhitch
----
#### Mod_Admin_Plus V25.09.21 2025/09/21
	- Se modificar el construtor de las tablas de horarios de usuarios:
			`error` varchar(5) NOT NULL default 'false',
	- Se modifican las tablas de control de horario:
			ALTER TABLE `map_abxxxxxxxxa_2025` ADD `error` VARCHAR(5) NOT NULL DEFAULT 'false' AFTER `ttot`;
	- Se modifican las consultas sql en php...
	- Ajustes generales...
----
#### Mod_Admin_Plus V25.09.20C 2025/09/20
	- Ajustes generales...
	- Sustitución de la etiqueta embed por audio
----
#### Mod_Admin_Plus V25.09.14B 2025/09/14
	- Ajustes generales en Balances.php
	- Se optimiza el menú de navegación.
	- Fichar Crear botonera de navegación.
	- Con sesión abierta redireccionamiento fichar con usuario no admin o webmaster...
----
#### Mod_Admin_Plus V25.09.13 2025/09/13
	- Ajustes de gráficos en Balances/
		- SE CAMBIA EL NOMBRE DE Balances_otr.php POR Balances.php
		- SE CANCELA BalancesUser.php ANTES Balances.php...
		- Ajustes generales en el código
----
#### Mod_Admin_Plus V25.09.11B 2025/09/11
	- Inclusión software bajo Licencia CC BY-NC-SA.
	  Creative Commons Reconocimiento-NoComercial-CompartirIgual (CC BY-NC-SA).
	- Ajustes de gráficos en Balances/
----
#### Mod_Admin_Plus V25.09.10 2025/09/10
	- Modificaciones en Balances...
----
#### Mod_Admin_Plus V25.09.09 2025/09/09
	- Modificaciones en la presentación del menu app.
	- Ajustes de código en número de empleados.
----
#### Mod_Admin_Plus V25.09.04 2025/09/04
	- Eliminación de la librería geoclass...
	- Bloqueo Ip: Sustitución de geoplugin.class.php $geoplugin->ip por Inclu/ipCliente.php
			if(!empty($_SERVER['HTTP_CLIENT_IP'])){
				$ipCliente = $_SERVER['HTTP_CLIENT_IP'];
			}...
	- Ok: Admin/Claves_Perdidas.php
	- Ok: $Orden en Inclu/orden.php
	- Ok: Embed ajustados parámetros por css...
	- Ajustes generales de código...

#### Mod_Admin_Plus V25.09.03 2025/09/03
	- Ok: Desbloqueo ip

#### Mod_Admin_Plus V25.09.02 2025/09/02
	* EN GESTION DE ADMINISTRADORES:
	- Ajustes generales...
	- No se puede fichar si el usuario está locked y redirección...

#### Mod_Admin_Plus V25.08.31 2025/09/31
	* EN GESTION DE ADMINISTRADORES:
	- Ajustes generales...
	- Ok: Baja temporal de usuario sin eliminar las tablas de la bbdd, ni directorios (recuperable).
	- Ok: Eliminación definitiva y total del usuario, tablas y directorios...
	- Ok: Modificación del estado "close" a "locked" de acceso al sistema del usuario.
	- Ok: logs de actividad del usuario.
----
#### Mod_Admin_Plus V25.08.30B 2025/08/30
	* EN GESTION DE ADMINISTRADORES:
	- Ok: Botonera navegación Admin y Admin_Feedback.
	- Ok: Recuperar Usuario Borrado.
	- Ok: Modificación del nombre de los archivos Admin/
----
#### Mod_Admin_Plus V25.08.29 2025/08/29
	* EN GESTION DE ADMINISTRADORES:
	- Ok: Dar de baja temporal a un usuario, papelera.
	- Ok: Modificación consultas Sql...
	- Ok: Eliminación y modificación de funciones feecback...
	- Ok: Paginación en Admin y Feedback, se modifican las consultas de paginación...
	- Ok: Ajuste de la botonera para Ver_Admin y Ver_Feedback...
	- Optimización de código, modificación de estilos, inclusión de iconos, sustitución de tablas...
----
#### Mod_Admin_Plus V25.08.28A 2025/08/28
	* EN GESTION DE ADMINISTRADORES:
	- Ok: Crear Administrador y modificar imagen de administrador.
	- Optimización de código, modificación de estilos, inclusión de iconos, sustitución de tablas...
----
#### Mod_Admin_Plus V25.08.27B 2025/08/27
	- Se modifica la estructura de la bbdd eliminando tablas y creando nuevos campos.
	- La codificación de la bbdd se modifica a CHARSET=utf16 COLLATE=utf16_spanish2_ci
	- Algunos métodos no funcionarán hasta ajustarlos a la nueva estructura.
	- Optimización de código, modificación de estilos, inclusión de iconos, sustitución de tablas...
----
#### Mod_Admin_Plus V25.08.26B 2025/08/26
	- Optimización de código, modificación de estilos, inclusión de iconos, sustitución de tablas...
	- Modificación de la persentación de usuarios y paginación.
	- Integración de nuevos audios con time delay.
----
#### Mod_Admin_Plus V25.07.31 2025/07/31
	- .\config\index_Play_System.php Modificación de estilos, inclusión de iconos, sustitución de tablas...
	- Nuevos iconos aplicación.
#### Mod_Admin_Plus V25.07.30 2025/07/30
	- Configurada la sincronización con GitHub desde HP2.
	- Reparado error con lector de codigos QR.

#### Mod_Admin_Plus V23.0.6 2023/08/28
	- AJUSTES GENERALES EN BBDD Y FORMULARIOS

#### CLPlus_V38(BetaOk) 2023/05/29
	- AJUSTES GENERALES EN fichar/

#### CLPlus_V38(BetaOk) 2023/05/29
	- AJUSTES GENERALES EN fichar/

#### CLPlus_V37(beta) 2023/05/28
	- ACTUALMENTE SE ESTÄ IMPLEMENTADO LA VERSIÓN ACTUALIZADA DEL MOD_ADMIN
	- CONFIRMACIÓN DE LA ISTALACIÓN INICIAL CORRECTA.
	- MODIFICACCIÓN DE RUTAS EN ADMIN CREAR NUEVO USUARIO.
	- CONFIRMACIÓN DE LA EXPORTACIÓN TOTAL DE LA BBDD.
	- CONFIRMACIÓN DE LA GENERACIÓN DE CÓDIGOS QR.
	- CONFIRMACIÓN DEL FUNCIONAMIENTO DE CÓDIGOS QR CONFIRMACIÓN USUARIO.
	- CONFIRMACIÓN DE LA CREACIÓN DE NUEVO USUARIO, DIRECTORIOS Y ARCHIVOS DEPENDIENTES.
	- VERIFICACIÓN DE MODIFICACIÓN DE IMAGEN.
	- INTEGRADO FORMULARIO DE FICHAR ANTES DE INICIAR SESIÓN.
	- COMPROBADO FINCHAR DESDE INICIO SIN ABRIR SESIÓN.
---
## TAREAS PENDIENTES.
	- VERIFICACIÓN DE FUNCIONES Y MENU DE NAVEGACIÓN.
	- VERIFICACIÓN DE CAMBIO DE AÑO Y CREACIÓN DE LAS TABLAS DEL USUARIO INIDVIDUAL.
----
	* EL ARCHIVO INDEX.PHP DE LA INSTALACION "CONEXION BBDD" INICIAL SE ELIMINA 
 	  SE SUSTITUYE POR CONFIG/INDEX_PLAY_SYSTEM.PHP
----
## ARCHIVOS QUE NO SE TIENEN QUE SOBRE ESCRIBIR SI LA APLICACION ESTA EN PRODUCCION EN EL SERVIDOR:
	* INDEX.PHP
	* CONECTIONS/CONECTION.PHP
	* CONFIG/YEAR.PHP
	* CONFIG/YEAR.TXT
	* INCLU/MYDNI.PHP
	* INCLU/NEMP.PHP
	* LOS DIRECTORIOS DE USUARIO Y SUS ARCHIVOS LOS GENERA/ELIMINA EL SISTEMA AUTOMATICAMENTE.
----
## DIFERENCIAS ENTRE LAS DOS VERSIONES DE CONTROL LABORAL
### DIFERENCIAS ENTRE LAS DOS VERSIONES ***

- Desde cualquier dispositivo o SO.
	- Optimizado para: Php.7.10, Apache.2.4.23, MySql.5.7.14.
	- Validado para usuarios: DNI / NIF / NIE.
	- Deteccion automatica entrada o salida.
- Fichar con Pin auto.
	- Fichar con Pin confirmacion.
- Fichar con Qr auto o confirmacion.
	- 4 niveles de usuario: admin / plus / user / close(bloqueado).
	- Acceso user / password (Opcional).
- Graficas actividad de usuario.
- Integracion Qr Scanner.
- Integracion Qr gen y exportacion personalizada de Qr's.

- BackUp auto bbdd sql dias 6/8/12/24/30 de cada mes.
- Exportacion personalizada BackUp auto bbdd sql.

- Exportacion personalizada user tbl bbdd.
- Exportacion user resumen mensual txt.
- Generacion automatica .log actividad usuario open session.
- Exportacion user actividad sistema .log.
- Users: Modif, Delete, Create.

- Feedback y recuperacion usuarios.

- Deteccion automatica de errores fichar >10h.
- Modificacion de horarios erroneos.
- Eliminacion entradas horarios.

- Recuperacion entradas horarios borradas.
- Notificacion inicio sesion via mail.
- Recuperacion claves acceso perdidas.
- Formulario de contacto Web Master.

- Bloqueo de la ip al tercer intento de acceso fallido user/pass.
- Desbloqueo autom�tico de la ip tras 1 hora.

- Desbloqueo de la ip con formulario de usuario.

- Bloqueo de cualquier usuario en modificacion usuarios.

- Audio aplicacion.

----
## Autor: © Juan Manuel Barrós Pazos 2020/25 Licencia CC BY-NC-SA
----
