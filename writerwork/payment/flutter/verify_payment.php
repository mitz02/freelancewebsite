<?php
session_start();
$secret_key = "FLWSECK_TEST-acfc064981812987e2989aade414859b-X"; // Replace with your secret key

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tx_ref = $_GET['tx_ref'];

    $url = "https://api.flutterwave.com/v3/transactions/".$tx_ref."/verify";
    
    $headers = [
        'Authorization: Bearer ' . $secret_key,
        'Content-Type: application/json',
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    // Check if the verification was successful
    if ($result && isset($result['status']) && $result['status'] === 'success') {
        // Extract relevant information
        $amount = $result['data']['amount'];
        $productName = $result['data']['meta']['custom_fields'][0]['value']; // Assuming product name is stored as a custom field
        $email = $result['data']['customer']['email'];

 include "../../include/connections.php";

      
        // Insert data into the table
        $sql = "INSERT INTO payment (amount, product_name, email, gateway) VALUES ('$amount', '$productName', '$email','flutterwave')";

        if ($conn->query($sql) === TRUE) {
            echo "Transaction verified successfully and data stored in MySQL!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        // Transaction failed or could not be verified
        echo "Transaction verification failed!";
        print_r($result);
    }
} else {
    // Handle invalid request method
    echo "Invalid request method";
}
?>
