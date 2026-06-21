<?php

namespace App\Mail;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;
use Illuminate\Support\Facades\Http;

class BrevoApiTransport extends AbstractTransport
{
    protected $apiKey;

    public function __construct(string $apiKey)
    {
        parent::__construct();
        $this->apiKey = $apiKey;
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $to = [];
        foreach ($email->getTo() as $address) {
            $to[] = [
                'email' => $address->getAddress(),
                'name'  => $address->getName() ?: null
            ];
        }

        $from = [
            'email' => $email->getFrom()[0]->getAddress(),
            'name'  => $email->getFrom()[0]->getName() ?: null
        ];

        $htmlContent = $email->getHtmlBody();
        $textContent = $email->getTextBody();

        if (empty($textContent) && !empty($htmlContent)) {
            $textContent = strip_tags($htmlContent);
        }

        $payload = [
            'sender'      => $from,
            'to'          => $to,
            'subject'     => $email->getSubject(),
            'htmlContent' => $htmlContent,
        ];

        if (!empty($textContent)) {
            $payload['textContent'] = $textContent;
        }

        // Penanganan lampiran jika ada
        $attachments = [];
        foreach ($email->getAttachments() as $attachment) {
            $headers = $attachment->getPreparedHeaders();
            $filename = $headers->getHeaderParameter('Content-Disposition', 'filename') ?: 'file';
            
            $attachments[] = [
                'name'    => $filename,
                'content' => base64_encode($attachment->getBody())
            ];
        }
        
        if (!empty($attachments)) {
            $payload['attachment'] = $attachments;
        }

        $response = Http::withHeaders([
            'api-key'      => $this->apiKey,
            'content-type' => 'application/json',
            'accept'       => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', $payload);

        if ($response->failed()) {
            throw new \Exception('Gagal mengirim email via Brevo API: ' . ($response->json('message') ?? $response->body()));
        }
    }

    public function __toString(): string
    {
        return 'brevo-api';
    }
}
