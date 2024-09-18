<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Utils\Logger;

$logFile = __DIR__ . '/../logs/index.log';
$logger = new Logger($logFile);

$visitorIP = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$requestURI = $_SERVER['REQUEST_URI'];
$httpMethod = $_SERVER['REQUEST_METHOD'];
$referrer = $_SERVER['HTTP_REFERER'] ?? 'No referrer';

$logEntry = "Visitor IP: $visitorIP | Request URI: $httpMethod $requestURI | Referrer: $referrer | User Agent: $userAgent";

$logger->info($logEntry);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello!</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            max-width: 600px;
            padding: 20px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 16px;
        }
        p {
            font-size: 16px;
            margin-bottom: 16px;
        }
        a {
            color: #0070f3;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Hello!</h1>
    <p>Nothing to see here, but take a look here:</p>
    <p><a href='https://dionpotkamp.nl?ref=twilio'>dionpotkamp.nl</a></p>
</div>
</body>
</html>
