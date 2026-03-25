<?php
// Replace with the PayMongo Secret Key
$secretKey = "YOUR_PAYMONGO_SECRET_KEY_HERE";

$amount = $_POST['amount'] * 100; // Convert to centavo


$data = [
    "data" => [
        "attributes" => [
            "amount" => $amount,
            "currency" => "PHP",
            "description" => "Sample Description",
            "remarks" => "Sample Remarks",
            "checkout_url" => "https://pm.link/org-sBNv7gWdxikVStjWLa5zEfBt/test/Yxj6GJs"
        ]
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/links");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Basic " . base64_encode($secretKey . ":")
]);

$result = curl_exec($ch);
curl_close($ch);

$response = json_decode($result, true);

if (isset($response['data']['attributes']['checkout_url'])) {
    // Redirect to the checkout URL for payment
    header("Location: " . $response['data']['attributes']['checkout_url']);
    exit();
} else {
    echo "Error creating payment link: " . print_r($response, true);
}
