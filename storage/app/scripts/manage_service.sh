#!/bin/bash
# Script para gestionar el servicio de consulta de cédulas

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PID_FILE="$SCRIPT_DIR/service.pid"
LOG_FILE="/tmp/consulta_service.log"

case "$1" in
    start)
        if [ -f "$PID_FILE" ]; then
            PID=$(cat "$PID_FILE")
            if ps -p $PID > /dev/null 2>&1; then
                echo "⚠ El servicio ya está corriendo (PID: $PID)"
                exit 1
            fi
        fi
        
        echo "🚀 Iniciando servicio de consulta de cédulas..."
        cd "$SCRIPT_DIR"
        source venv/bin/activate
        nohup python consulta_cedula_2captcha.py > "$LOG_FILE" 2>&1 &
        echo $! > "$PID_FILE"
        echo "✓ Servicio iniciado (PID: $(cat $PID_FILE))"
        echo "📋 Logs en: $LOG_FILE"
        ;;
    
    stop)
        if [ ! -f "$PID_FILE" ]; then
            echo "⚠ El servicio no está corriendo"
            exit 1
        fi
        
        PID=$(cat "$PID_FILE")
        if ps -p $PID > /dev/null 2>&1; then
            echo "🛑 Deteniendo servicio (PID: $PID)..."
            kill $PID
            sleep 2
            if ps -p $PID > /dev/null 2>&1; then
                echo "⚠ Forzando cierre..."
                kill -9 $PID
            fi
            rm -f "$PID_FILE"
            echo "✓ Servicio detenido"
        else
            echo "⚠ El proceso no está corriendo"
            rm -f "$PID_FILE"
        fi
        ;;
    
    restart)
        $0 stop
        sleep 2
        $0 start
        ;;
    
    status)
        if [ -f "$PID_FILE" ]; then
            PID=$(cat "$PID_FILE")
            if ps -p $PID > /dev/null 2>&1; then
                echo "✓ Servicio corriendo (PID: $PID)"
                echo "📋 Logs: $LOG_FILE"
                echo ""
                echo "Últimas líneas del log:"
                tail -n 5 "$LOG_FILE" 2>/dev/null || echo "No hay logs aún"
            else
                echo "✗ El servicio no está corriendo (PID file existe pero proceso no)"
                rm -f "$PID_FILE"
            fi
        else
            echo "✗ El servicio no está corriendo"
        fi
        ;;
    
    logs)
        if [ -f "$LOG_FILE" ]; then
            tail -f "$LOG_FILE"
        else
            echo "⚠ No hay archivo de log"
        fi
        ;;
    
    *)
        echo "Uso: $0 {start|stop|restart|status|logs}"
        echo ""
        echo "Comandos:"
        echo "  start   - Iniciar el servicio"
        echo "  stop    - Detener el servicio"
        echo "  restart - Reiniciar el servicio"
        echo "  status  - Ver estado del servicio"
        echo "  logs    - Ver logs en tiempo real"
        exit 1
        ;;
esac


