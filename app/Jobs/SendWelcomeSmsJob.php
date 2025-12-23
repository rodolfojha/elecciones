<?php

namespace App\Jobs;

use App\Models\Voter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWelcomeSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $voter;

    /**
     * Create a new job instance.
     */
    public function __construct(Voter $voter)
    {
        $this->voter = $voter;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $phone = $this->voter->telefono;

        // Limpieza básica del número (solo dígitos y +)
        $cleanNumber = preg_replace('/[^\d+]/', '', $phone);

        // Validar longitud mínima (asumiendo Colombia +57... o al menos 10 dígitos)
        if (strlen($cleanNumber) < 10) {
            Log::warning("SendWelcomeSmsJob: Número inválido o muy corto: {$phone}");
            return;
        }

        // Asegurar formato E.164
        if (!str_starts_with($cleanNumber, '+')) {
             if (strlen($cleanNumber) == 10) {
                 // Si son 10 dígitos exactos, asumimos Colombia (+57)
                 $cleanNumber = '+57' . $cleanNumber;
             } elseif (strlen($cleanNumber) > 10) {
                 // Si tiene más de 10 dígitos (ej: 34644... = 11 dígitos, o 58424... = 12 dígitos)
                 // Asumimos que ya trae el código de país y solo le falta el '+'
                 $cleanNumber = '+' . $cleanNumber;
             }
        }

        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $from = env('TWILIO_FROM');

        if (!$sid || !$token || !$from) {
            Log::error("SendWelcomeSmsJob: Credenciales de Twilio no configuradas en .env");
            return;
        }

        $message = "Hola {$this->voter->nombre}, ¡gracias por registrarte! Tu información de votación está siendo consultada.";

        try {
            Log::info("SendWelcomeSmsJob: Enviando SMS a {$cleanNumber}");
            
            $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";
            
            $response = Http::withBasicAuth($sid, $token)->asForm()->post($url, [
                'To' => $cleanNumber,
                'From' => $from,
                'Body' => $message
            ]);

            if ($response->successful()) {
                Log::info("SendWelcomeSmsJob: SMS enviado correctamente. SID: " . $response->json('sid'));
            } else {
                Log::error("SendWelcomeSmsJob: Error Twilio: " . $response->body());
            }

        } catch (\Exception $e) {
            Log::error("SendWelcomeSmsJob: Excepción: " . $e->getMessage());
        }
    }
}
