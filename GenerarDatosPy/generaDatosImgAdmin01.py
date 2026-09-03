# CREA LOS DATOS, ESTRUCTURA DE DIRECTORIOS E IMÁGENES COMO NOMBRE LA REFERENCIA DEL USUARIO EN MINÚSCULAS .PNG EN TEMPADMINDIR.
# SI SE USAN ESTOS DATOS, SE HAN DE COPIAR LOS DIRECTORIOS DE USUARIOS EN EL DIRECTORIO Users/

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

# Directorios de trabajo
DIRECTORIO_ADMIN = "TempAdminDir"
DIRECTORIO_DOC_COMMON = "DocCommon"
DIRECTORIO_IMG_AUTO = "ImgAuto"

# Configuración de imágenes
NOMBRE_IMAGEN_BASE = "untitled.png"

# Listas de datos ficticios
NOMBRES = ["Juan", "Maria", "Carlos", "Ana", "Luis", "Laura", "Pedro", "Sofia", "Diego", "Elena"]
APELLIDOS = ["Garcia", "Martinez", "Lopez", "Sanchez", "Rodriguez", "Fernandez", "Perez", "Gomez"]
NIVELES = ["wmaster", "admin", "plus", "user", "locked"]

# Definición de rutas base
DIRECTORIO_ACTUAL = Path(__file__).parent.resolve()
RUTA_TEMP_ADMIN = DIRECTORIO_ACTUAL / DIRECTORIO_ADMIN
RUTA_DOC_COMMON = DIRECTORIO_ACTUAL / DIRECTORIO_DOC_COMMON
RUTA_IMG_AUTO = DIRECTORIO_ACTUAL / DIRECTORIO_IMG_AUTO


# ==========================================
# FUNCIONES AUXILIARES
# ==========================================
def calcular_letra_dni(dni_num: int) -> str:
    # Calcula la letra correspondiente a un número de DNI español (en minúscula).
    letras = "trwagmyfpdxbnjzsqvhlcke"
    return letras[dni_num % 23]


def limpiar_img_auto():
    # Vacía el directorio ImgAuto si existe, preservando únicamente la imagen base.
    if not RUTA_IMG_AUTO.exists() or not RUTA_IMG_AUTO.is_dir():
        return

    print(f"* Limpiando contenido de {DIRECTORIO_IMG_AUTO} (respetando '{NOMBRE_IMAGEN_BASE}')...")
    for elemento in RUTA_IMG_AUTO.iterdir():
        if elemento.is_file():
            if elemento.name != NOMBRE_IMAGEN_BASE:
                elemento.unlink()
        elif elemento.is_dir():
            shutil.rmtree(elemento)
    print(f"* {DIRECTORIO_IMG_AUTO} limpiado correctamente.")


def limpiar_y_preparar_temp_admin() -> Path | None:
    # Prepara el directorio TempAdminDir vaciándolo completamente al inicio,
    # utilizando directamente la imagen ubicada en DocCommon.
    if not RUTA_TEMP_ADMIN.exists():
        print(f"Error: La carpeta '{DIRECTORIO_ADMIN}' no existe en {DIRECTORIO_ACTUAL}.")
        return None

    # Limpiar también ImgAuto si existe
    limpiar_img_auto()

    # Buscar directamente la imagen en DocCommon/untitled.png
    ruta_imagen_base = RUTA_DOC_COMMON / NOMBRE_IMAGEN_BASE

    if not ruta_imagen_base.exists():
        print(f"Error: No se encontró la imagen base '{NOMBRE_IMAGEN_BASE}' en {RUTA_DOC_COMMON}.")
        return None

    # Guardar copia temporal de la imagen base fuera de TempAdminDir
    ruta_temp_base = DIRECTORIO_ACTUAL / f"_temp_{NOMBRE_IMAGEN_BASE}"
    shutil.copy2(ruta_imagen_base, ruta_temp_base)

    # Vaciar completamente TempAdminDir
    print(f"* Limpiando contenido anterior de {DIRECTORIO_ADMIN}...")
    for elemento in RUTA_TEMP_ADMIN.iterdir():
        if elemento.is_dir():
            shutil.rmtree(elemento)
        elif elemento.is_file():
            elemento.unlink()

    print(f"* {DIRECTORIO_ADMIN} limpiado correctamente.")
    return ruta_temp_base


def crear_estructura_usuario(ref: str, myimg: str, ruta_base_temp: Path):
    # Crea la estructura de carpetas (en minúsculas) y copia los archivos para un usuario dentro de TempAdminDir.
    ruta_usuario = RUTA_TEMP_ADMIN / ref.lower()
    ruta_img_admin = ruta_usuario / "img_admin"
    ruta_log = ruta_usuario / "log"
    ruta_mrficha = ruta_usuario / "mrficha"

    # 1. Crear directorios del usuario en minúsculas
    ruta_img_admin.mkdir(parents=True, exist_ok=True)
    ruta_log.mkdir(parents=True, exist_ok=True)
    ruta_mrficha.mkdir(parents=True, exist_ok=True)

    # 2. Copiar en img_admin tanto la imagen base como la imagen del usuario (en minúsculas)
    shutil.copy2(ruta_base_temp, ruta_img_admin / NOMBRE_IMAGEN_BASE)
    shutil.copy2(ruta_base_temp, ruta_img_admin / myimg.lower())

    # 3. Copiar todos los archivos de DocCommon a la raíz de la carpeta del usuario
    if RUTA_DOC_COMMON.exists() and RUTA_DOC_COMMON.is_dir():
        for elemento in RUTA_DOC_COMMON.iterdir():
            if elemento.is_file():
                shutil.copy2(elemento, ruta_usuario / elemento.name)


# ==========================================
# GENERACIÓN DE DATOS Y COPIAS
# ==========================================
def generar_bloque_valores(cantidad: int) -> list:
    # Genera los registros SQL y construye las carpetas de usuario en TempAdminDir.
    ruta_base_temp = limpiar_y_preparar_temp_admin()
    if not ruta_base_temp:
        return []

    valores = []
    print(f"\n* Generando {cantidad} registros y estructuras de usuario en minúsculas...")

    try:
        for i in range(1, cantidad + 1):
            # 1. Datos personales
            nombre = random.choice(NOMBRES)
            apellidos = f"{random.choice(APELLIDOS)} {random.choice(APELLIDOS)}"
            dni_num = random.randint(10000000, 99999999)
            ldni = calcular_letra_dni(dni_num)
            nivel = random.choice(NIVELES)

            # 2. Referencia e Imagen del usuario (todo formateado a minúsculas)
            primera_letra = nombre[0].lower()
            ref = f"{primera_letra}{dni_num}{ldni}".lower()
            myimg = f"{ref}.png"

            # 3. Crear estructura completa en TempAdminDir/<ref>
            crear_estructura_usuario(ref, myimg, ruta_base_temp)
            print(f"   + Generado usuario [{ref}] en {DIRECTORIO_ADMIN}/{ref}")

            # 4. Credenciales y contacto
            nombre_limpio = nombre.lower()
            usuario = f"usr{random.randint(10, 99)}"[:10]
            email = f"{nombre_limpio}{random.randint(10, 99)}@example.com"
            
            pass_plain = f"Pass{random.randint(100, 999)}"[:10]
            password_hash = f"$2y$10${random.randint(100000000000000000, 999999999999999999)}"[:100]

            tlf1 = random.randint(600000000, 999999999)
            tlf2 = random.randint(600000000, 999999999)
            
            nombre_esc = nombre.replace("'", "''")
            apellidos_esc = apellidos.replace("'", "''")

            # 5. Construcción de la fila SQL (con ref, ldni y myimg en minúsculas)
            fila = (
                f"({i}, '{ref}', '{nivel}', '{nombre_esc}', '{apellidos_esc}', '{myimg}', 'DNI', "
                f"'{dni_num}', '{ldni}', '{email}', '{usuario}', '{password_hash}', '{pass_plain}', "
                f"'Calle Principal {i}', {tlf1}, {tlf2}, NOW(), NOW(), 0, 'false', NULL, NULL)"
            )
            valores.append(fila)

    finally:
        # Eliminar el archivo temporal de la imagen base al finalizar
        if ruta_base_temp and ruta_base_temp.exists():
            ruta_base_temp.unlink()

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