<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Utils\Logger;
use App\Utils\TwilioRequestValidator;
use App\Service\TwilioService;
use App\Service\MailService;
use App\Controller\TwilioController;

$config = require __DIR__ . '/../config/config.php';
$logger = new Logger($config['logger']['file_path']);

$logger->info("Twilio webhook accessed.");

$validator = new TwilioRequestValidator($config['twilio_auth_token']);
$twilioService = new TwilioService($validator, $logger);

$emailService = new MailService(
    $config['email']['from'],
    $config['email']['to'],
);

$controller = new TwilioController($twilioService, $emailService, $logger);

$controller->handle();

$logger->info("Twilio webhook processing completed.");
