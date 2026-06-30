<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class BrevoMailer
{
    private static string $apiUrl = 'https://api.brevo.com/v3/smtp/email';
    private static string $fromEmail = 'noreply@the-sprout-academy.com';
    private static string $fromName = 'The Sprout Academy';

    public static function sendFormSubmission(
        string $toEmail,
        string $formType,
        string $title,
        array $formData
    ): bool {
        $submittedAt = now()->format('F j, Y \a\t g:i A');

        $html = View::make('emails.form-submission', [
            'formType'    => $formType,
            'title'       => $title,
            'formData'    => $formData,
            'submittedAt' => $submittedAt,
        ])->render();

        $response = Http::withHeaders([
            'api-key'      => env('BREVO_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(self::$apiUrl, [
            'sender'      => ['name' => self::$fromName, 'email' => self::$fromEmail],
            'to'          => [['email' => $toEmail]],
            'subject'     => $title . ' - The Sprout Academy',
            'htmlContent' => $html,
        ]);

        if (!$response->successful()) {
            Log::error('Brevo API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;
        }

        return true;
    }
}
