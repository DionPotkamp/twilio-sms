<?php
namespace App\Controller;

use App\Service\TwilioService;
use App\Service\MailService;
use App\Utils\Logger;
use Exception;

class TwilioController
{
    private TwilioService $twilioService;
    private MailService $emailService;
    private Logger $logger;

    public function __construct(TwilioService $twilioService, MailService $emailService, Logger $logger)
    {
        $this->twilioService = $twilioService;
        $this->emailService = $emailService;
        $this->logger = $logger;
    }

    /**
     * Handle the incoming Twilio webhook request.
     */
    public function handle(): void
    {
        $twilioSignature = $_SERVER['HTTP_X_TWILIO_SIGNATURE'] ?? '';

        // Construct full URL
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") .
            "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        $postParams = $_POST;

        if (!$this->twilioService->validateRequest($twilioSignature, $url, $postParams)) {
            $this->logger->warning("Forbidden access attempt with invalid signature.");

            http_response_code(403);
            exit;
        }

        $from = $postParams['From'] ?? 'Unknown';
        $body = $postParams['Body'] ?? 'Empty';
        $timestamp = $postParams['Timestamp'] ?? date('Y-m-d H:i:s');

        // Prepare email content
        $subject = "New SMS from $from";
        $emailBody = "You have received a new SMS message.\n\n" .
            "From: $from\n" .
            "Message: $body\n" .
            "Received at: $timestamp\n";

        try {
            $this->emailService->sendEmail($subject, $emailBody);

            $this->logger->info("Processed SMS from {$from} and sent email.");
            http_response_code(200);
        } catch (Exception $e) {
            $this->logger->error("Failed to send email for SMS from {$from}, body: {$body}, timestamp: {$timestamp}");
            $this->logger->error($e->getMessage());
            $this->logger->error($e->getTraceAsString());

            http_response_code(500);
        }
    }
}
