<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class GraphMailer
{
    private static function getAccessToken(): ?string
    {
        $tenantId     = env('MSGRAPH_TENANT_ID');
        $clientId     = env('MSGRAPH_CLIENT_ID');
        $clientSecret = env('MSGRAPH_CLIENT_SECRET');

        $response = Http::asForm()->post(
            "https://login.microsoftonline.com/{$tenantId}/oauth2/v2.0/token",
            [
                'grant_type'    => 'client_credentials',
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'scope'         => 'https://graph.microsoft.com/.default',
            ]
        );

        if (!$response->successful()) {
            Log::error('GraphMailer: token fetch failed', ['body' => $response->body()]);
            return null;
        }

        return $response->json('access_token');
    }

    public static function send(string $toEmail, string $subject, string $htmlBody): bool
    {
        $token = self::getAccessToken();
        if (!$token) {
            return false;
        }

        $fromEmail = env('MSGRAPH_FROM_EMAIL', 'noreply@the-sprout-academy.com');

        $response = Http::withToken($token)
            ->post("https://graph.microsoft.com/v1.0/users/{$fromEmail}/sendMail", [
                'message' => [
                    'subject' => $subject,
                    'body'    => [
                        'contentType' => 'HTML',
                        'content'     => $htmlBody,
                    ],
                    'toRecipients' => [
                        ['emailAddress' => ['address' => $toEmail]],
                    ],
                ],
                'saveToSentItems' => false,
            ]);

        if (!$response->successful()) {
            Log::error('GraphMailer: send failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;
        }

        return true;
    }

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

        return self::send($toEmail, $title . ' - The Sprout Academy', $html);
    }
}
