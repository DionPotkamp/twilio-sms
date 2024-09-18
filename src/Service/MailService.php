<?php
namespace App\Service;

use App\Utils\Logger;
use Exception;

class MailService
{
    private string $from;
    private string $to;

    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * Send an email with the provided subject and body.
     *
     * @param string $subject
     * @param string $body
     * @return void
     * @throws Exception
     */
    public function sendEmail(string $subject, string $body): void
    {
        $success = mail(
            $this->to,
            $subject,
            $body,
            array(
                'From' => $this->from,
                'Reply-To' => $this->to,
                'X-Mailer' => 'PHP/' . phpversion()
            )
        );

        if (!$success) {
           throw new Exception("Failed to send email.");
        }
    }
}
