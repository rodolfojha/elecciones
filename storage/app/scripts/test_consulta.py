#!/usr/bin/env python3
"""
Script de prueba para consultar cedula directamente desde terminal
"""

import os
import sys
import time
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
from webdriver_manager.chrome import ChromeDriverManager

# Configuracion
TWOCAPTCHA_API_KEY = "717ce26f1b3537da97312bab40f9ddad"
URL_CONSULTA = "https://wsp.registraduria.gov.co/censo/consultar/"

class TwoCaptchaSolver:
    """Resuelve CAPTCHAs usando el servicio 2Captcha"""
    
    API_URL_IN = "http://2captcha.com/in.php"
    API_URL_RES = "http://2captcha.com/res.php"
    
    def __init__(self, api_key):
        self.api_key = api_key
    
    def solve_recaptcha_v2(self, site_key, page_url):
        """Resuelve reCAPTCHA v2 usando 2Captcha"""
        import requests
        
        print(f"\n[CAPTCHA] Enviando reCAPTCHA a 2Captcha...")
        
        # Paso 1: Enviar el CAPTCHA
        try:
            response = requests.post(
                self.API_URL_IN,
                data={
                    "key": self.api_key,
                    "method": "userrecaptcha",
                    "googlekey": site_key,
                    "pageurl": page_url,
                    "json": 1
                },
                timeout=30
            )
            
            result = response.json()
            
            if result.get("status") != 1:
                print(f"[ERROR] Error enviando CAPTCHA: {result}")
                return None
            
            captcha_id = result.get("request")
            print(f"[OK] CAPTCHA enviado. ID: {captcha_id}")
            
        except Exception as e:
            print(f"[ERROR] {e}")
            return None
        
        # Paso 2: Esperar solucion
        print(f"[WAIT] Esperando solucion de 2Captcha...")
        
        for i in range(40):
            time.sleep(5)
            
            try:
                response = requests.get(
                    self.API_URL_RES,
                    params={
                        "key": self.api_key,
                        "action": "get",
                        "id": captcha_id,
                        "json": 1
                    },
                    timeout=30
                )
                
                result = response.json()
                
                if result.get("status") == 1:
                    token = result.get("request")
                    print(f"[OK] CAPTCHA resuelto!")
                    return token
                elif result.get("request") == "CAPCHA_NOT_READY":
                    print(f"[WAIT] Intento {i+1}/40...")
                    continue
                else:
                    print(f"[ERROR] {result}")
                    return None
                    
            except Exception as e:
                print(f"[ERROR] Error consultando solucion: {e}")
                continue
        
        print("[ERROR] Timeout esperando solucion")
        return None

def test_consulta(cedula):
    """Prueba de consulta con una cedula"""
    
    print(f"\n{'='*60}")
    print(f"PRUEBA DE CONSULTA DE CEDULA")
    print(f"{'='*60}")
    print(f"Cedula: {cedula}")
    print(f"URL: {URL_CONSULTA}")
    print(f"{'='*60}\n")
    
    # Configurar Chrome
    print("[CHROME] Iniciando navegador Chrome...")
    opciones = Options()
    # opciones.add_argument('--headless')  # Comentado para ver el navegador
    opciones.add_argument('--no-sandbox')
    opciones.add_argument('--disable-dev-shm-usage')
    opciones.add_argument('--disable-blink-features=AutomationControlled')
    
    try:
        # Usar ChromeDriver directamente desde la cache
        chromedriver_path = r"C:\Users\vic\.wdm\drivers\chromedriver\win64\143.0.7499.42\chromedriver-win32\chromedriver.exe"
        service = Service(chromedriver_path)
        driver = webdriver.Chrome(service=service, options=opciones)
        print("[OK] Navegador iniciado")
    except Exception as e:
        print(f"[ERROR] Error iniciando navegador: {e}")
        return
    
    try:
        # Cargar pagina
        print(f"\n[WEB] Cargando pagina...")
        driver.get(URL_CONSULTA)
        time.sleep(2)
        print("[OK] Pagina cargada")
        
        wait = WebDriverWait(driver, 20)
        
        # Buscar campo de documento
        print(f"\n[FORM] Buscando campo de cedula...")
        campo = wait.until(EC.presence_of_element_located((By.ID, "nuip")))
        print("[OK] Campo encontrado")
        
        # Ingresar documento
        print(f"\n[INPUT] Ingresando cedula: {cedula}")
        campo.clear()
        time.sleep(0.5)
        campo.send_keys(cedula)
        print("[OK] Cedula ingresada")
        
        # Seleccionar dropdown
        print(f"\n[SELECT] Buscando dropdown de tipo de consulta...")
        try:
            select_element = wait.until(EC.presence_of_element_located((By.ID, "tipo")))
            select = Select(select_element)
            print(f"[OK] Dropdown encontrado")
            print(f"     Opciones disponibles:")
            for option in select.options:
                print(f"     - {option.get_attribute('value')}: {option.text}")
            
            print(f"\n[SELECT] Seleccionando 'LUGAR DE VOTACION ACTUAL...' (valor: -1)")
            select.select_by_value("-1")
            time.sleep(0.5)
            print("[OK] Opcion seleccionada")
        except Exception as e:
            print(f"[WARN] No se pudo seleccionar dropdown: {e}")
            print("       Continuando de todos modos...")
        
        # Obtener site key
        print(f"\n[CAPTCHA] Buscando site key de reCAPTCHA...")
        site_key = driver.execute_script("""
            var iframe = document.querySelector('iframe[src*="google.com/recaptcha"]');
            if (iframe) {
                var src = iframe.getAttribute('src');
                var match = src.match(/k=([^&]+)/);
                return match ? match[1] : null;
            }
            return null;
        """)
        
        if not site_key:
            print("[ERROR] No se encontro site key")
            input("\nPresiona Enter para cerrar el navegador...")
            return
        
        print(f"[OK] Site key encontrado: {site_key[:20]}...")
        
        # Resolver CAPTCHA
        print(f"\n[2CAPTCHA] Resolviendo CAPTCHA con 2Captcha...")
        solver = TwoCaptchaSolver(TWOCAPTCHA_API_KEY)
        token = solver.solve_recaptcha_v2(site_key, URL_CONSULTA)
        
        if not token:
            print("[ERROR] No se pudo resolver el CAPTCHA")
            input("\nPresiona Enter para cerrar el navegador...")
            return
        
        # Inyectar token
        print(f"\n[INJECT] Inyectando token de CAPTCHA...")
        driver.execute_script(f"""
            document.getElementById('g-recaptcha-response').innerHTML = '{token}';
            if (typeof window['___grecaptcha_cfg'] !== 'undefined') {{
                var clients = window['___grecaptcha_cfg']['clients'];
                for (var client in clients) {{
                    if (clients[client].callback) {{
                        clients[client].callback('{token}');
                    }}
                }}
            }}
        """)
        time.sleep(1)
        print("[OK] Token inyectado")
        
        # Enviar formulario
        print(f"\n[SUBMIT] Enviando formulario...")
        try:
            boton = wait.until(EC.element_to_be_clickable((By.ID, "enviar")))
            boton.click()
        except:
            driver.execute_script("document.getElementById('enviar').click()")
        
        print("[OK] Formulario enviado")
        
        # Esperar resultados
        print(f"\n[WAIT] Esperando resultados...")
        time.sleep(5)
        
        print(f"\n{'='*60}")
        print("CONSULTA COMPLETADA")
        print(f"{'='*60}")
        print("\nRevisa el navegador para ver los resultados.")
        input("\nPresiona Enter para cerrar el navegador...")
        
    except Exception as e:
        print(f"\n[ERROR] ERROR: {e}")
        import traceback
        traceback.print_exc()
        input("\nPresiona Enter para cerrar el navegador...")
    
    finally:
        driver.quit()
        print("\n[END] Navegador cerrado")

if __name__ == "__main__":
    if len(sys.argv) > 1:
        cedula = sys.argv[1]
    else:
        cedula = input("Ingresa el numero de cedula: ")
    
    test_consulta(cedula)
