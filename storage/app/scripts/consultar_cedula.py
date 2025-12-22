#!/usr/bin/env python3
"""
Script para consultar cédulas en la Registraduría Nacional de Colombia
Usa Selenium con la extensión NopeCHA para resolver captchas automáticamente
"""

import sys
import json
import time
import os
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException

# Configuración
URL_REGISTRADURIA = "https://wsp.registraduria.gov.co/censo/consultar/"
TIMEOUT = 60  # Tiempo máximo de espera para el captcha

def crear_driver(extension_path=None):
    """Crear instancia de Chrome con opciones configuradas"""
    chrome_options = Options()
    
    # Opciones para servidor sin interfaz gráfica
    chrome_options.add_argument("--headless=new")  # Modo headless nuevo
    chrome_options.add_argument("--no-sandbox")
    chrome_options.add_argument("--disable-dev-shm-usage")
    chrome_options.add_argument("--disable-gpu")
    chrome_options.add_argument("--window-size=1920,1080")
    chrome_options.add_argument("--disable-blink-features=AutomationControlled")
    chrome_options.add_argument("--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36")
    
    # Cargar extensión NopeCHA si existe
    if extension_path and os.path.exists(extension_path):
        chrome_options.add_argument(f"--load-extension={extension_path}")
        # Si usamos extensión, no podemos usar headless
        chrome_options.arguments.remove("--headless=new")
    
    # Preferencias adicionales
    chrome_options.add_experimental_option("excludeSwitches", ["enable-automation"])
    chrome_options.add_experimental_option('useAutomationExtension', False)
    
    try:
        driver = webdriver.Chrome(options=chrome_options)
        driver.execute_cdp_cmd("Page.addScriptToEvaluateOnNewDocument", {
            "source": """
                Object.defineProperty(navigator, 'webdriver', {
                    get: () => undefined
                })
            """
        })
        return driver
    except Exception as e:
        print(json.dumps({
            "success": False,
            "message": f"Error al iniciar Chrome: {str(e)}",
            "data": None
        }))
        sys.exit(1)

def consultar_cedula(cedula, extension_path=None):
    """Consultar información de votación por cédula"""
    driver = None
    resultado = {
        "success": False,
        "message": "",
        "data": None
    }
    
    try:
        driver = crear_driver(extension_path)
        driver.get(URL_REGISTRADURIA)
        
        wait = WebDriverWait(driver, 20)
        
        # Esperar a que cargue la página
        time.sleep(2)
        
        # Buscar el campo de cédula (puede tener diferentes nombres)
        campo_cedula = None
        posibles_selectores = [
            "input[name='nuip']",
            "input[name='cedula']",
            "input[name='documento']",
            "input[type='text']",
            "#nuip",
            "#cedula"
        ]
        
        for selector in posibles_selectores:
            try:
                campo_cedula = driver.find_element(By.CSS_SELECTOR, selector)
                if campo_cedula.is_displayed():
                    break
            except NoSuchElementException:
                continue
        
        if not campo_cedula:
            resultado["message"] = "No se encontró el campo de cédula en la página"
            return resultado
        
        # Ingresar la cédula
        campo_cedula.clear()
        campo_cedula.send_keys(cedula)
        
        # Buscar y hacer clic en el botón de consultar
        boton_consultar = None
        posibles_botones = [
            "input[type='submit']",
            "button[type='submit']",
            "input[value='Consultar']",
            "button:contains('Consultar')",
            ".btn-primary",
            "#consultar"
        ]
        
        for selector in posibles_botones:
            try:
                boton_consultar = driver.find_element(By.CSS_SELECTOR, selector)
                if boton_consultar.is_displayed():
                    break
            except NoSuchElementException:
                continue
        
        if boton_consultar:
            boton_consultar.click()
        else:
            # Intentar enviar el formulario directamente
            campo_cedula.submit()
        
        # Esperar a que se resuelva el captcha (NopeCHA lo hará automáticamente)
        # y aparezcan los resultados
        time.sleep(5)  # Dar tiempo para el captcha
        
        # Esperar hasta TIMEOUT segundos para los resultados
        for _ in range(TIMEOUT // 5):
            time.sleep(5)
            
            # Verificar si hay resultados
            page_source = driver.page_source.lower()
            
            if "puesto" in page_source or "votación" in page_source or "departamento" in page_source:
                break
            
            # Verificar si hay error
            if "no se encontr" in page_source or "no existe" in page_source:
                resultado["message"] = "No se encontró información para esta cédula"
                return resultado
        
        # Extraer información
        data = extraer_informacion(driver, cedula)
        
        if data:
            resultado["success"] = True
            resultado["message"] = "Información encontrada"
            resultado["data"] = data
        else:
            resultado["message"] = "No se pudo extraer la información. La página puede haber cambiado."
        
    except TimeoutException:
        resultado["message"] = "Tiempo de espera agotado. El captcha no se resolvió a tiempo."
    except Exception as e:
        resultado["message"] = f"Error durante la consulta: {str(e)}"
    finally:
        if driver:
            driver.quit()
    
    return resultado

def extraer_informacion(driver, cedula):
    """Extraer información de la página de resultados"""
    data = {
        "cedula": cedula,
        "departamento": None,
        "municipio": None,
        "puesto_votacion": None,
        "direccion_puesto": None
    }
    
    try:
        page_source = driver.page_source
        
        # Intentar encontrar tablas con información
        tablas = driver.find_elements(By.TAG_NAME, "table")
        
        for tabla in tablas:
            filas = tabla.find_elements(By.TAG_NAME, "tr")
            for fila in filas:
                celdas = fila.find_elements(By.TAG_NAME, "td")
                if len(celdas) >= 2:
                    etiqueta = celdas[0].text.strip().lower()
                    valor = celdas[1].text.strip()
                    
                    if "departamento" in etiqueta:
                        data["departamento"] = valor
                    elif "municipio" in etiqueta:
                        data["municipio"] = valor
                    elif "puesto" in etiqueta:
                        data["puesto_votacion"] = valor
                    elif "direcci" in etiqueta:
                        data["direccion_puesto"] = valor
        
        # Si no se encontró en tablas, buscar en divs/spans
        if not any([data["departamento"], data["municipio"], data["puesto_votacion"]]):
            # Buscar por texto
            elementos = driver.find_elements(By.XPATH, "//*[contains(text(), ':')]")
            for elem in elementos:
                texto = elem.text.strip()
                if ":" in texto:
                    partes = texto.split(":", 1)
                    if len(partes) == 2:
                        etiqueta = partes[0].strip().lower()
                        valor = partes[1].strip()
                        
                        if "departamento" in etiqueta and not data["departamento"]:
                            data["departamento"] = valor
                        elif "municipio" in etiqueta and not data["municipio"]:
                            data["municipio"] = valor
                        elif "puesto" in etiqueta and not data["puesto_votacion"]:
                            data["puesto_votacion"] = valor
                        elif "direcci" in etiqueta and not data["direccion_puesto"]:
                            data["direccion_puesto"] = valor
        
        # Verificar si se encontró algo
        if any([data["departamento"], data["municipio"], data["puesto_votacion"], data["direccion_puesto"]]):
            return data
        
        return None
        
    except Exception as e:
        print(f"Error extrayendo información: {e}", file=sys.stderr)
        return None

def main():
    """Función principal"""
    if len(sys.argv) < 2:
        print(json.dumps({
            "success": False,
            "message": "Uso: python consultar_cedula.py <numero_cedula> [ruta_extension_nopecha]",
            "data": None
        }))
        sys.exit(1)
    
    cedula = sys.argv[1].strip()
    extension_path = sys.argv[2] if len(sys.argv) > 2 else None
    
    # Validar cédula
    cedula = ''.join(filter(str.isdigit, cedula))
    if len(cedula) < 5:
        print(json.dumps({
            "success": False,
            "message": "Número de cédula inválido",
            "data": None
        }))
        sys.exit(1)
    
    resultado = consultar_cedula(cedula, extension_path)
    print(json.dumps(resultado, ensure_ascii=False))

if __name__ == "__main__":
    main()



