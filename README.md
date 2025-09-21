## © Juan M. Barrós Pazos. Bajo Licencia CC BY-NC-SA.

### Reconocimiento: © Juan M. Barrós Pazos.
### Contacto: juanbarrospazos@hotmail.es
## Licencia CC BY-NC-SA.
    Creative Commons Reconocimiento-NoComercial-CompartirIgual (CC BY-NC-SA).

    Esta licencia permite copiar, distribuir y modificar una obra (copyleft), pero exige que se reconozca la autoría (CC BY), que el uso no sea comercial (NC), y que cualquier obra derivada se comparta bajo la misma licencia o una compatible (SA).
----
## PENDIENTES...
#### Ojo modificar el contenido de los mensajes en los log de actividad de los Admin...
----
## ULTIMAS MODIFICACIONES.
#### Mod_Admin_Plus V25.09.21 2025/08/21
	- Se modificar el construtor de las tablas de horarios de usuarios:
			`error` varchar(5) NOT NULL default 'false',
	- Se modifican las tablas de control de horario:
			ALTER TABLE `map_abxxxxxxxxa_2025` ADD `error` VARCHAR(5) NOT NULL DEFAULT 'false' AFTER `ttot`;
	- Se modifican las consultas sql en php...
	- Ajustes generales...
----
#### Mod_Admin_Plus V25.09.20C 2025/08/20
	- Ajustes generales...
	- Sustitución de la etiqueta embed por audio
----
#### Mod_Admin_Plus V25.09.14B 2025/08/14
	- Ajustes generales en Balances.php
	- Se optimiza el menú de navegación.
	- Fichar Crear botonera de navegación.
	- Con sesión abierta redireccionamiento fichar con usuario no admin o webmaster...
----
#### Mod_Admin_Plus V25.09.13 2025/08/13
	- Ajustes de gráficos en Balances/
		- SE CAMBIA EL NOMBRE DE Balances_otr.php POR Balances.php
		- SE CANCELA BalancesUser.php ANTES Balances.php...
		- Ajustes generales en el código
----
#### Mod_Admin_Plus V25.09.11B 2025/08/11
	- Inclusión software bajo Licencia CC BY-NC-SA.
	  Creative Commons Reconocimiento-NoComercial-CompartirIgual (CC BY-NC-SA).
	- Ajustes de gráficos en Balances/
----
#### Mod_Admin_Plus V25.09.10 2025/08/10
	- Modificaciones en Balances...
----
#### Mod_Admin_Plus V25.09.09 2025/08/09
	- Modificaciones en la presentación del menu app.
	- Ajustes de código en número de empleados.
----
#### Mod_Admin_Plus V25.09.04 2025/08/04
	- Eliminación de la librería geoclass...
	- Bloqueo Ip: Sustitución de geoplugin.class.php $geoplugin->ip por Inclu/ipCliente.php
			if(!empty($_SERVER['HTTP_CLIENT_IP'])){
					$ipCliente = $_SERVER['HTTP_CLIENT_IP'];
			}elseif($_SERVER['REMOTE_ADDR'] == getenv("REMOTE_ADDR")){
					$ipCliente = $_SERVER['REMOTE_ADDR'];
			}elseif(!empty(getenv("REMOTE_ADDR"))){
					$ipCliente = getenv("REMOTE_ADDR");
			}elseif(!empty($_SERVER['REMOTE_ADDR'])){
					$ipCliente = $_SERVER['REMOTE_ADDR'];
			}elseif(getenv($_SERVER['HTTP_X-FORWARDED_FOR'])){
					$ipCliente = $_SERVER['HTTP_X-FORWARDED_FOR'];
			}elseif(getenv($_SERVER['HTTP_X_FORWARDED'])){
					$ipCliente = $_SERVER['HTTP_X_FORWARDED'];
			}elseif(getenv($_SERVER['HTTP_FORWARDED_FOR'])){
					$ipCliente = $_SERVER['HTTP_FORWARDED_FOR'];
			}elseif(getenv($_SERVER['HTTP_FORWARDED'])){
					$ipCliente = $_SERVER['HTTP_FORWARDED'];
			}else{ echo "NO SE DETECTA LA IP DEL CLIENTE"; }
	- Ok: Admin/Claves_Perdidas.php
	- Ok: $Orden en Inclu/orden.php
	- Ok: Embed ajustados parámetros por css...
	- Ajustes generales de código...

#### Mod_Admin_Plus V25.09.03 2025/08/03
	- Ok: Desbloqueo ip

#### Mod_Admin_Plus V25.09.02 2025/08/02
	* EN GESTION DE ADMINISTRADORES:
	- Ajustes generales...
	- No se puede fichar si el usuario está locked y redirección...

#### Mod_Admin_Plus V25.08.31 2025/08/31
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
