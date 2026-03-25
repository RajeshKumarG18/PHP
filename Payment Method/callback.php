<?php
$input = file_get_contents("php://input");
$event = json_decode($input, true);

if ($event['data']['attributes']['status'] == "paid") {
    $paymentId = $event['data']['id'];
    file_put_contents("payments.log", "Payment successful for ID: " . $paymentId . "\n", FILE_APPEND);
} else {
    file_put_contents("payments.log", "Payment failed or pending\n", FILE_APPEND);
}

http_response_code(200);