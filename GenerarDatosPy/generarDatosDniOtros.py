# GENERA DATOS ALEATORIOS PARA COMPROBAR LAS VALIDACIÓN DE LOS DOCUMENTOS OFICIALES...

import random
import os

def calcular_letra_dni(numero_str: str) -> str:
    """Calcula la letra de control para DNI, NIE y NIF especiales (K, L, M)."""
    letras = "TRWAGMYFPDXBNJZSQVHLCKE"
    return letras[int(numero_str) % 23]

def calcular_control_juridico(letra: str, siete_digitos: str) -> str:
    """Calcula el dígito o letra de control para NIFs de personas jurídicas."""
    # Sumar dígitos en posiciones pares desde la izquierda
    suma_pares = int(siete_digitos[1]) + int(siete_digitos[3]) + int(siete_digitos[5])
    
    # Multiplicar por 2 posiciones impares y sumar sus dígitos
    suma_impares = 0
    for i in [0, 2, 4, 6]:
        prod = int(siete_digitos[i]) * 2
        suma_impares += (prod // 10) + (prod % 10)
        
    suma_total = suma_pares + suma_impares
    unidades = suma_total % 10
    digito = 0 if unidades == 0 else 10 - unidades
    
    if letra in ['P', 'Q', 'R', 'S', 'W', 'N']:
        return "JABCDEFGHI"[digito]
    return str(digito)

def generar_y_exportar():
    ejemplos = {}

    # 1. DNI
    ejemplos['DNI'] = []
    for _ in range(3):
        num = "".join([str(random.randint(0, 9)) for _ in range(8)])
        ejemplos['DNI'].append(f"{num}{calcular_letra_dni(num)}")

    # 2. NIE
    ejemplos['NIE'] = []
    for i, prefijo in enumerate(['X', 'Y', 'Z']):
        num_7 = "".join([str(random.randint(0, 9)) for _ in range(7)])
        num_calculo = str(i) + num_7
        ejemplos['NIE'].append(f"{prefijo}{num_7}{calcular_letra_dni(num_calculo)}")

    # 3. NIF Jurídicos
    letras_juridicas = {
        'A': 'NIF_A Sociedad Anónima', 'B': 'NIF_B Sociedad Responsabilidad Limitada', 'C': 'NIF_C Sociedad Colectiva', 'D': 'NIF_D Sociedad Comanditaria', 'E': 'NIF_E Comunidad Bienes y Herencias Yacentes',
        'F': 'NIF_F Sociedade Cooperativa', 'G': 'NIF_G Asociaciones', 'H': 'NIF_H Comunidad Propietarios', 'J': 'NIF_J Sociedad Civil', 'N': 'NIF_N Entidad Extranjera', 'P': 'NIF_P Corporaciones Locales', 'Q': 'NIF_Q Organismo Público', 'R': 'NIF_R Congregaciones Instituciones Religiosas', 'S': 'NIF_S Órganos Admin. Estado y CCAA', 'U': 'NIF_U Uniones Temporales Empresas', 'V': 'NIF_V Otros tipos no definidos', 'W': 'NIF_W Establecimientos Permanentes Entidades no Residentes'
    }

    for l, clave in letras_juridicas.items():
        ejemplos[clave] = []
        for _ in range(3):
            provincia = random.choice(["28", "08", "41", "50", "12"])
            resto = "".join([str(random.randint(0, 9)) for _ in range(5)])
            cuerpo = provincia + resto
            control = calcular_control_juridico(l, cuerpo)
            ejemplos[clave].append(f"{l}{cuerpo}{control}")

    # 4. NIF Personas Físicas Especiales (K, L, M)
    # FIX: antes solo se generaba 1 ejemplo por letra y los tres se mezclaban
    # en una única lista bajo la misma clave, sin poder distinguir cuál era
    # K, cuál L y cuál M. Ahora se generan 3 ejemplos por letra, cada uno
    # en su propia clave, igual que el resto de bloques.
    letras_especiales = {
        'K': 'NIF_Especial_K Español menor de 14 años sin DNI',
        'L': 'NIF_Especial_L Español residente en el extranjero sin DNI',
        'M': 'NIF_Especial_M Extranjero sin NIE asignado',
    }
    for l, clave in letras_especiales.items():
        ejemplos[clave] = []
        for _ in range(3):
            num_7 = "".join([str(random.randint(0, 9)) for _ in range(7)])
            ejemplos[clave].append(f"{l}{num_7}{calcular_letra_dni(num_7)}")

    # --- ESCRITURA DEL ARCHIVO TXT ---
    # OJO RUTA EN MCGESTION2026
    nombre_archivo = f"Mod_Admin_Plus/GenerarDatosPy/DatosDniOtrosRandom.txt"
    
    # Extrae la ruta de la carpeta ("GenerarDatosPy")
    carpeta = os.path.dirname(nombre_archivo)
    
    # Crea la carpeta automáticamente si no existe en el directorio
    if carpeta and not os.path.exists(carpeta):
        os.makedirs(carpeta)
    
    # Ahora ya puedes abrir y escribir el archivo sin errores
    with open(nombre_archivo, "w", encoding="utf-8") as f:
        f.write("=== DATOS DE PRUEBA GENERADOS AUTOMÁTICAMENTE ===\n\n")
        for tipo, lista_valores in ejemplos.items():
            valores_str = ", ".join(lista_valores)
            f.write(f"{tipo}: {valores_str}\n")
            
    print(f"Éxito: Archivo guardado correctamente en: {os.path.abspath(nombre_archivo)}")

if __name__ == "__main__":
    generar_y_exportar()