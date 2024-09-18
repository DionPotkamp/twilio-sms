<?php
namespace App\Utils;

use Twilio\Security\RequestValidator;

class TwilioRequestValidator
{
    private RequestValidator $validator;
    private string $authToken;

    public function __construct(string $authToken)
    {
        $this->authToken = $authToken;
        $this->validator = new RequestValidator($this->authToken);
    }

    /**
     * Validate the incoming request from Twilio.
     *
     * @param string $signature The X-Twilio-Signature header.
     * @param string $url The full URL of the webhook.
     * @param array $postParams The POST parameters.
     * @return bool
     */
    public function isValid(string $signature, string $url, array $postParams): bool
    {
       return $this->validator->validate($signature, $url, $postParams);
    }
}
