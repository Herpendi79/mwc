<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class EmailApiService
{
    public static function sendkirimemail($to, $subject, $text, $html)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://smtp-app.kirim.email/api/v4/transactional/message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_USERPWD => env('KIRIM_EMAIL_API_KEY') . ':' . env('KIRIM_EMAIL_API_SECRET'),
            CURLOPT_HTTPHEADER => [
                'domain: ' . env('KIRIM_EMAIL_DOMAIN'),
            ],
            CURLOPT_POSTFIELDS => http_build_query([
                'from'      => 'conference@adaksi.org',
                'from_name' => 'ICPIP-HE 2026',
                'to'        => $to,
                'subject'   => $subject,
                'text'      => $text,
                'html'      => $html,
            ]),
        ]);

        $response = curl_exec($curl);
        $error    = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        Log::info('Kirim.email API', [
            'to'        => $to,
            'subject'   => $subject,
            'http_code' => $httpCode,
            'response'  => $response,
        ]);

        if ($error) {
            throw new \Exception($error);
        }

        if (!in_array($httpCode, [200, 202])) {
            throw new \Exception($response);
        }

        return true;
    }

    public static function send($to, $subject, $text, $html = null)
    {
        $apiToken   = env('KIRIM_MAILKETING_API_KEY');
        $fromName   = env('MAIL_FROM_NAME', 'ICPIP-HE 2026');
        $fromEmail  = env('MAIL_FROM_EMAIL', 'no-reply@conference.adaksi.org');

        // gunakan html kalau ada, kalau tidak pakai text
        $content = $html ?? '<pre>' . $text . '</pre>';

        $params = [
            'from_name'  => $fromName,
            'from_email' => $fromEmail,
            'recipient'  => $to,
            'subject'    => $subject,
            'content'    => $content,
            'api_token'  => $apiToken,
        ];

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.mailketing.co.id/api/v1/send",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        // 🔥 LOG DEBUG
        Log::info('Mailketing API', [
            'to'        => $to,
            'subject'   => $subject,
            'http_code' => $httpCode,
            'response'  => $response,
            'error'     => $error,
        ]);

        if ($error) {
            throw new \Exception($error);
        }

        $result = json_decode($response, true);

        // Mailketing biasanya sukses kalau status true
        if (!$result || (isset($result['status']) && $result['status'] != true)) {
            throw new \Exception($response);
        }

        return true;
    }
}
