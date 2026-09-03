# CREA LOS DATOS Y LAS IMÁGENES COMO NOMBRE LA REFERENCIA DEL USUARIO .PNG EN TempAdminDir
# SE RECOMIENDA USAR generaDatosImgAdmin01.py QUE GENERA TODA LA ESTRUCTURA DEL DIRECTORIO DE USUARIO

import os
import random
import shutil
from pathlib import Path

# ==========================================
# CONFIGURACIÓN GENERAL
# ==========================================
CANTIDAD_DATOS = 20

# Configuración de archivos y directorios
NOMBRE_ARCHIVO_SQL = "DatosAutoAdmin.sql"
TABLA_SQL = "`db_name`.`table_name`"

# Configuración de imágenes
CARPETA_IMAGENES = "ImgAuto"
NOMBRE_IMAGEN_BASE = "untitled.png"
EXTENSIONES_IMAGEN = {".png", ".jpg", ".jpeg", ".gif", ".webp", ".bmp"}

# Listas de datos ficticios
NOMBRES = ["Juan", "Maria", "Carlos", "Ana", "Luis", "Laura", "Pedro", "Sofia", "Diego", "Elena"]
APELLIDOS = ["Garcia", "Martinez", "Lopez", "Sanchez", "Rodriguez", "Fernandez", "Perez", "Gomez"]
NIVELES = ["wmaster", "admin", "plus", "user", "locked"]

# Definición de rutas base
DIRECTORIO_ACTUAL = Path(__file__).parent.resolve()
RUTA_CARPETA_IMG = DIRECTORIO_ACTUAL / CARPETA_IMAGENES
RUTA_IMAGEN_BASE = RUTA_CARPETA_IMG / NOMBRE_IMAGEN_BASE


# ==========================================
# FUNCIONES AUXILIARES
# ==========================================
def calcular_letra_dni(dni_num: int) -> str:
    # Calcula la letra correspondiente a un número de DNI español.
    letras = "TRWAGMYFPDXBNJZSQVHLCKE"
    return letras[dni_num % 23]


def preparar_y_limpiar_imagenes() -> bool:
    # Asegura que exista el directorio de imágenes y elimina copias antiguas.
    # 1. Crear carpeta si no existe
    RUTA_CARPETA_IMG.mkdir(parents=True, exist_ok=True)

    # 2. Validar que la imagen base exista
    if not RUTA_IMAGEN_BASE.exists():
        print(f"Error: No se encontró '{NOMBRE_IMAGEN_BASE}' en '{RUTA_CARPETA_IMG}'.")
        return False

    # 3. Limpiar imágenes antiguas manteniendo la base
    print(f"* Limpiando imágenes antiguas...")
    archivos_borrados = 0
    for archivo in RUTA_CARPETA_IMG.iterdir():
        if archivo.is_file() and archivo.name != NOMBRE_IMAGEN_BASE:
            if archivo.suffix.lower() in EXTENSIONES_IMAGEN:
                archivo.unlink()
                archivos_borrados += 1
                print(f"- Borrado: {archivo.name}")

    print(f"* {archivos_borrados} imágenes antiguas eliminadas.")
    return True


# ==========================================
# GENERACIÓN DE DATOS Y COPIAS
# ==========================================
def generar_bloque_valores(cantidad: int) -> list:
    # Genera los registros SQL y copia las imágenes correspondientes con la REF.
    if not preparar_y_limpiar_imagenes():
        return []

    valores = []
    print(f"\n* Generando {cantidad} registros e imágenes...")

    for i in range(1, cantidad + 1):
        # 1. Datos personales
        nombre = random.choice(NOMBRES)
        apellidos = f"{random.choice(APELLIDOS)} {random.choice(APELLIDOS)}"
        dni_num = random.randint(10000000, 99999999)
        ldni = calcular_letra_dni(dni_num)
        nivel = random.choice(NIVELES)

        # 2. Referencia e Imagen
        primera_letra = nombre[0].upper()
        ref = f"{primera_letra}{dni_num}{ldni}".lower()
        myimg = f"{ref}.png"
        print(f"  + Creada: {myimg}")

        # 3. Copia de la imagen con el nombre de la REF
        ruta_destino = RUTA_CARPETA_IMG / myimg
        shutil.copy2(RUTA_IMAGEN_BASE, ruta_destino)

        # 4. Credenciales y contacto
        nombre_limpio = nombre.lower()
        usuario = f"usr{random.randint(10, 99)}"[:10]
        email = f"{nombre_limpio}{random.randint(10, 99)}@example.com"
        
        # Simulación de contraseñas (plana y hash/encriptada)
        pass_plain = f"Pass{random.randint(100, 999)}"[:10]
        password_hash = f"$2y$10${random.randint(100000000000000000, 999999999999999999)}"[:100]

        tlf1 = random.randint(600000000, 999999999)
        tlf2 = random.randint(600000000, 999999999)
        
        # Escapado para consultas SQL
        nombre_esc = nombre.replace("'", "''")
        apellidos_esc = apellidos.replace("'", "''")

        # 5. Construcción de la fila SQL ajustada a la nueva tabla
        fila = (
            f"({i}, '{ref}', '{nivel}', '{nombre_esc}', '{apellidos_esc}', '{myimg}', 'DNI', "
            f"'{dni_num}', '{ldni}', '{email}', '{usuario}', '{password_hash}', '{pass_plain}', "
            f"'Calle Principal {i}', {tlf1}, {tlf2}, NOW(), NOW(), 0, 'false', NULL, NULL)"
        )
        valores.append(fila)

    return valores


def guardar_archivo_sql(valores: list, ruta_relativa_sql: str):
    # Guarda las sentencias de inserción SQL en la ruta indicada.
    if not valores:
        print("No hay datos para guardar en el archivo SQL.")
        return

    ruta_archivo_sql = DIRECTORIO_ACTUAL / ruta_relativa_sql
    ruta_archivo_sql.parent.mkdir(parents=True, exist_ok=True)

    bloque_valores = ",\n".join(valores)
    sql_completo = (
        f"INSERT INTO {TABLA_SQL} "
        f"(`id`, `ref`, `Nivel`, `Nombre`, `Apellidos`, `myimg`, `doc`, `dni`, `ldni`, "
        f"`Email`, `Usuario`, `Password`, `Pass`, `Direccion`, `Tlf1`, `Tlf2`, `lastin`, "
        f"`lastout`, `visitadmin`, `del`, `borrado`, `recuper`) "
        f"VALUES\n{bloque_valores};"
    )

    with open(ruta_archivo_sql, "w", encoding="utf-8") as f:
        f.write(sql_completo)

    print(f"\n¡ÉXITO! Archivo '{ruta_archivo_sql.name}' generado con {len(valores)} registros.\n")


# ==========================================
# EJECUCIÓN PRINCIPAL
# ==========================================
if __name__ == "__main__":
    registros = generar_bloque_valores(CANTIDAD_DATOS)
    guardar_archivo_sql(registros, NOMBRE_ARCHIVO_SQL)