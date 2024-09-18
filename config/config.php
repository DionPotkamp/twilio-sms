<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return [
    'twilio_auth_token' => $_ENV['TWILIO_AUTH_TOKEN'],
    'smtp' => [
        'host' => $_ENV['SMTP_HOST'],
        'username' => $_ENV['SMTP_USERNAME'],
        'password' => $_ENV['SMTP_PASSWORD'],
        'port' => $_ENV['SMTP_PORT'],
    ],
    'email' => [
        'from' => $_ENV['EMAIL_FROM'],
        'to' => $_ENV['EMAIL_TO'],
    ],
    'logger' => [
        'file_path' => __DIR__ . '/../logs/app.log',
    ],
];
