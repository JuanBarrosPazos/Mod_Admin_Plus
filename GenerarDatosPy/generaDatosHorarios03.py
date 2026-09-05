'''
GENERA LOS DATOS PARA LOS AÑOS 2023 A 2026 DE FORMA ALEATORIA EN ARCHIVOS INDIVIDUALES ANUALES...
INCLUYE LA CREACION DE LA TABLA  Y LOS DATOS ANIDADOS EN GRUPOS DE 150 ENTRADAS...
'''
import random
from datetime import datetime, timedelta

# Configuración inicial
usuarios = ['jbp55555555k', 'abp44444444a', 'mp33333333p', 'mf22222222j']
años = [2023, 2024, 2025, 2026]
meses_por_año = {
    2023: list(range(1, 13)),
    2024: list(range(1, 13)),
    2025: list(range(1, 13)),
    2026: list(range(1, 9)) # Transcurrido del 2026 (hasta junio)
}

TAMANO_LOTE = 150 # Máximo de entradas por cada sentencia INSERT

for año in años:
    sql_output = []
    id_counter = 1 # Se reinicia el contador para cada año/tabla
    tabla = f"adm_horarios_{año}"
    
    # 1. Definición y creación de la estructura de la tabla para el año actual
    create_table_sql = f"""CREATE TABLE IF NOT EXISTS `{tabla}` (
  `id` int NOT NULL auto_increment,
  `ref` varchar(20) collate utf8mb4_spanish2_ci NOT NULL,
  `datein` varchar(10) collate utf8mb4_spanish2_ci NOT NULL,
  `timein` time NOT NULL,
  `dateout` varchar(10) collate utf8mb4_spanish2_ci NULL,
  `timeout` time NULL,
  `hourstot` time NULL,
  `errorhourstot` varchar(5) NOT NULL default 'false',
  `del` varchar(5) NOT NULL default 'false',
  `deldate` varchar(10) collate utf8mb4_spanish2_ci NULL,
  `deltime` time NULL,
  UNIQUE KEY `id` (`id`),
  KEY `ref` (`ref`),
  FOREIGN KEY (`ref`) REFERENCES `adm_admin` (`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci AUTO_INCREMENT=1;

"""
    sql_output.append(create_table_sql)
    
    # Lista temporal para acumular los bloques de valores (VALUES) de este año
    valores_acumulados = []
    
    # 2. Generación de los datos simulados
    for mes in meses_por_año[año]:
        if mes in [4, 6, 9, 11]: max_dias = 30
        elif mes == 2: max_dias = 29 if año % 4 == 0 else 28
        else: max_dias = 31
        
        # Seleccionar al menos 14 días aleatorios en el mes
        dias_laborales = sorted(random.sample(range(1, max_dias + 1), random.randint(14, 20)))
        
        for dia in dias_laborales:
            fecha_str = f"{año}-{mes:02d}-{dia:02d}"
            usuarios_del_dia = random.sample(usuarios, random.randint(2, len(usuarios)))
            
            for ref in usuarios_del_dia:
                # Generar horas y tiempos
                h_in = random.randint(7, 14)
                m_in = random.choice([0, 15, 30, 45])
                tin = f"{h_in:02d}:{m_in:02d}:00"
                
                duracion_horas = random.randint(4, 9)
                duracion_minutos = random.choice([0, 15, 30, 45])
                
                t_entrada = datetime.strptime(tin, "%H:%M:%S")
                t_salida = t_entrada + timedelta(hours=duracion_horas, minutes=duracion_minutos)
                tout = t_salida.strftime("%H:%M:%S")
                
                ttot = f"{duracion_horas:02d}:{duracion_minutos:02d}:00"
                #error = 'true' if duracion_horas > 8 or (duracion_horas == 8 and duracion_minutos > 0) else 'false'
                error = 'true' if duracion_horas > 9 or (duracion_horas == 9 and duracion_minutos > 0) else 'false'
                
                # Crear la tupla de valores en formato string para el bloque VALUES
                valor_sql = f"({id_counter}, '{ref}', '{fecha_str}', '{tin}', '{fecha_str}', '{tout}', '{ttot}', '{error}', 'false', NULL, NULL)"
                valores_acumulados.append(valor_sql)
                id_counter += 1
                
                # Si alcanzamos el límite de 150 registros, empaquetamos y escribimos el INSERT masivo
                if len(valores_acumulados) == TAMANO_LOTE:
                    insert_base = f"INSERT INTO `{tabla}` (`id`, `ref`, `datein`, `timein`, `dateout`, `timeout`, `hourstot`, `errorhourstot`, `del`, `deldate`, `deltime`) VALUES \n"
                    sql_completo = insert_base + ",\n".join(valores_acumulados) + ";"
                    sql_output.append(sql_completo)
                    valores_acumulados = [] # Vaciar el lote

    # Al salir de los bucles, si quedaron registros pendientes (< 150), los empaquetamos también
    if valores_acumulados:
        insert_base = f"INSERT INTO `{tabla}` (`id`, `ref`, `datein`, `timein`, `dateout`, `timeout`, `hourstot`, `errorhourstot`, `del`, `deldate`, `deltime`) VALUES \n"
        sql_completo = insert_base + ",\n".join(valores_acumulados) + ";"
        sql_output.append(sql_completo)

    # Guardar en su archivo SQL correspondiente
    # OJO RUTA EN MCGESTION2026
    nombre_archivo = f"Mod_Admin_Plus/GenerarDatosPy/adm_horarios_{año}.sql"
    with open(nombre_archivo, "w", encoding="utf-8") as f:
        f.write("\n\n".join(sql_output))
    
    print(f"Archivo '{nombre_archivo}' generado con éxito (Estructura + {id_counter - 1} filas en lotes de {TAMANO_LOTE}).")