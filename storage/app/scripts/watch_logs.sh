#!/bin/bash
# Script para ver los logs del servicio en tiempo real

LOG_FILE="/tmp/consulta_service.log"

echo "📋 Monitoreando logs del servicio de consultas..."
echo "   Presiona Ctrl+C para salir"
echo "   =========================================="
echo ""

tail -f "$LOG_FILE"

