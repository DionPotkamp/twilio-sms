<?php

namespace App\Service;

use App\Utils\Logger;
use App\Utils\TwilioRequestValidator;

class TwilioService
{
    private TwilioRequestValidator $validator;
    private Logger $logger;

    public function __construct(TwilioRequestValidator $validator, Logger $logger)
    {
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * Validate if the incoming request is from Twilio.
     *
     * @param string $signature
     * @param string $url
     * @param array $postParams
     * @return bool
     */
    public function validateRequest(string $signature, string $url, array $postParams): bool
    {
        $isValid = $this->validator->isValid($signature, $url, $postParams);

        if ($isValid) {
            $this->logger->info("Valid Twilio request.");
        } else {
            $this->logger->warning("Invalid Twilio request detected.");
        }

        return $isValid;
    }
}
