'''
GENERA LOS DATOS PARA LOS AÑOS 2023 A 2026 DE FORMA ALEATORIA EN ARCHIVOS INDIVIDUALES ANUALES...
INCLUYE LA CREACION DE LA TABLA  Y LOS DATOS ANIDADOS EN GRUPOS DE 150 ENTRADAS...
GENERA DATOS HASTA EL DÍA DE HOY SOLO LA ENTRADA ALEATORIA DE LOS USUARIOS...
INCLUYE LA VARIABLE LIMITE_HORAS_ERROR = 9 PARA MÁXIMO DE HORAS PERMITIDAS...
'''
import random
import datetime  # Importamos el módulo completo para evitar conflictos de nombres

# ==========================================
# CONFIGURACIÓN PERSONALIZABLE
# ==========================================
usuarios = ['jb55555555k', 'ambp44444444a', 'mpf33333333p', 'mf22222222j', 'bf11111111h', 'us66666666q', 'us77777777b', 'uo88888888y', 'un99999999r']
años = [2023, 2024, 2025, 2026]
TAMANO_LOTE = 150  # Máximo de entradas por cada sentencia INSERT

# Define aquí las horas a partir de las cuales se considerará error (ej: 8, 9, 10...)
LIMITE_HORAS_ERROR = 9 
# ==========================================

# Corrección aquí: Usando el módulo completo
fecha_hoy = datetime.date.today()

for año in años:
    if año > fecha_hoy.year:
        continue
        
    sql_output = []
    id_counter = 1  # Se reinicia el contador para cada año/tabla
    tabla = f"mcg_horarios_{año}"
    
    # 1. Definición de la estructura de la tabla
    create_table_sql = f"""CREATE TABLE IF NOT EXISTS `{tabla}` (
  `id` int NOT NULL auto_increment,
  `ref` varchar(20) collate utf16_spanish2_ci NOT NULL,
  `din` DATE NOT NULL DEFAULT (CURRENT_DATE()),
  `tin` time NOT NULL,
  `dout` DATE NULL,
  `tout` time NULL,
  `ttot` time NULL,
  `error` varchar(5) NOT NULL default 'false',
  `del` varchar(5) NOT NULL default 'false',
  `dfeed` DATE NULL,
  `tfeed` time NULL,
  UNIQUE KEY `id` (`id`),
  KEY `ref` (`ref`),
  FOREIGN KEY (`ref`) REFERENCES `mcg_admin`(`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1;

"""
    sql_output.append(create_table_sql)
    valores_acumulados = []
    
    # Determinar meses
    if año == fecha_hoy.year:
        meses = list(range(1, fecha_hoy.month + 1))
    else:
        meses = list(range(1, 13))
        
    # 2. Generación de los datos
    for mes in meses:
        if mes in [4, 6, 9, 11]: max_dias = 30
        elif mes == 2: max_dias = 29 if año % 4 == 0 else 28
        else: max_dias = 31
        
        # Si es el mes actual del año actual, limitamos los días hasta hoy
        if año == fecha_hoy.year and mes == fecha_hoy.month:
            max_dias = fecha_hoy.day
            
        min_requerido = min(14, max_dias)
        if max_dias < 1:
            continue
            
        dias_laborales = sorted(random.sample(range(1, max_dias + 1), random.randint(min_requerido, max_dias)))
        
        # Asegurarnos de que el día de hoy esté incluido si estamos en el mes/año actual
        if año == fecha_hoy.year and mes == fecha_hoy.month and fecha_hoy.day not in dias_laborales:
            dias_laborales.append(fecha_hoy.day)
            dias_laborales.sort()
        
        for dia in dias_laborales:
            fecha_str = f"{año}-{mes:02d}-{dia:02d}"
            usuarios_del_dia = random.sample(usuarios, random.randint(2, len(usuarios)))
            
            # Comprobar si el registro que estamos creando corresponde exactamente al día de hoy
            es_hoy = (año == fecha_hoy.year and mes == fecha_hoy.month and dia == fecha_hoy.day)
            
            for ref in usuarios_del_dia:
                # Generar hora de entrada (común para todos los días)
                h_in = random.randint(7, 14)
                m_in = random.choice([0, 15, 30, 45])
                tin = f"{h_in:02d}:{m_in:02d}:00"
                
                if es_hoy:
                    # EXCEPCIÓN PARA HOY: Solo entrada, salidas en NULL y sin error
                    dout = "NULL"
                    #tout = "NULL"
                    tout = "'00:00:00'"
                    #ttot = "NULL"
                    ttot = "'00:00:00'"
                    error = 'false'
                else:
                    # COMPORTAMIENTO NORMAL: Calcular salidas y errores dinámicos
                    duracion_horas = random.randint(4, 11) # Rango amplio para testear tu límite de errores
                    duracion_minutos = random.choice([0, 15, 30, 45])
                    
                    # Corrección aquí: Usando la clase datetime desde el módulo corregido
                    t_entrada = datetime.datetime.strptime(tin, "%H:%M:%S")
                    t_salida = t_entrada + datetime.timedelta(hours=duracion_horas, minutes=duracion_minutos)
                    
                    dout = f"'{fecha_str}'"
                    tout = f"'{t_salida.strftime('%H:%M:%S')}'"
                    ttot = f"'{duracion_horas:02d}:{duracion_minutos:02d}:00'"
                    
                    # Evalúa el error basándose en la variable LIMITE_HORAS_ERROR que tú configures
                    if duracion_horas > LIMITE_HORAS_ERROR or (duracion_horas == LIMITE_HORAS_ERROR and duracion_minutos > 0):
                        error = 'true'
                    else:
                        error = 'false'
                
                # Crear la tupla de valores
                valor_sql = f"({id_counter}, '{ref}', '{fecha_str}', '{tin}', {dout}, {tout}, {ttot}, '{error}', 'false', NULL, NULL)"
                valores_acumulados.append(valor_sql)
                id_counter += 1
                
                if len(valores_acumulados) == TAMANO_LOTE:
                    insert_base = f"INSERT INTO `{tabla}` (`id`, `ref`, `din`, `tin`, `dout`, `tout`, `ttot`, `error`, `del`, `dfeed`, `tfeed`) VALUES \n"
                    sql_completo = insert_base + ",\n".join(valores_acumulados) + ";"
                    sql_output.append(sql_completo)
                    valores_acumulados = []

    if valores_acumulados:
        insert_base = f"INSERT INTO `{tabla}` (`id`, `ref`, `din`, `tin`, `dout`, `tout`, `ttot`, `error`, `del`, `dfeed`, `tfeed`) VALUES \n"
        sql_completo = insert_base + ",\n".join(valores_acumulados) + ";"
        sql_output.append(sql_completo)

    # OJO RUTA EN MCGESTION2026
    nombre_archivo = f"Mod_Admin_Plus/GenerarDatosPy/mcg_horarios_{año}.sql"
    with open(nombre_archivo, "w", encoding="utf-8") as f:
        f.write("\n\n".join(sql_output))
    
    #print(f"Archivo '{nombre_archivo}' generado con éxito.")
    print(f"Archivo '{nombre_archivo}' generado con éxito (Estructura + {id_counter - 1} filas en lotes de {TAMANO_LOTE}).")