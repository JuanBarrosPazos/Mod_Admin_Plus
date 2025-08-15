
## Mod_Admin_Plus V25.08.15 2025/08/15

----
## ULTIMAS MODIFICACIONES.
#### Mod_Admin_Plus V25.08.06 2025/08/15
	- Optimización de código, modificación de estilos, inclusión de iconos, sustitución de tablas...
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
## Autor: Juan Manuel Barrós Pazos 2020/2025
----
