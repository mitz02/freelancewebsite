<?php
session_start();
include "../../include/connections.php";

if (!isset($_SESSION["email"])) {
    header("location: ../pages/login.html?user=not-set");
    exit;
}
$email = $_SESSION["email"];
$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$num = mysqli_num_rows($query);
if ($num < 1) {
    header("location: ../pages/login.html?user=not-set");
    exit;
}
if (!isset($_GET["orderID"])) {
    header("location: ../../user/userpage2.php?no-product");
    exit;
}
$orderId = $_GET["orderID"];
$orderQuery =  mysqli_query($conn, "SELECT * FROM orders WHERE email='$email' AND orderId='$orderId'");
$ordernum  = mysqli_num_rows($orderQuery);
if ($ordernum < 1) {
    header("location: ../pages/login.html?order=not-order");
    exit;
}

$rows = mysqli_fetch_assoc($orderQuery);
$price =  $rows["price"];
$title = $rows["title"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <style>
        form {
            width: 90%;
            margin: 50px auto;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h3 {
            font-size: 30px;
        }

        h4 {
            font-size: 20px;
            margin-bottom: 0;
            color: orangered;
        }

        form button {
            width: 100%;
        }

        button {
            background: #106d46;
            border: none;
            color: orangered;
            padding: 10px 0;
        }
    </style>
</head>

<body>

    <form method="POST" action="">
        <div>
            <h4>Pay <?php echo $price; ?> for this Order</h4>
            <h3><?php echo $title; ?></h3>
        </div>
        <button name="submit" type="submit">Pay Now</button>
    </form>

    <?php
    if(isset($_POST["submit"])){
        $amount = $price;
        $first_name = "Nil";
        $last_name = "Nils";
        $customer_email = $email;
    
        // Capture payment information
        $paymentInfo = [
            'tx_ref' => time(),
            'amount' => $amount,
            'currency' => 'NGN',
            'payment_options' => 'card',
            'customer_email' => $customer_email,
            'customer_name' => $first_name . ' ' . $last_name
        ];
    
        // Call Flutterwave endpoint
        $request = [
            'tx_ref' => $paymentInfo['tx_ref'],
            'amount' => $paymentInfo['amount'],
            'currency' => $paymentInfo['currency'],
            'payment_options' => $paymentInfo['payment_options'],
            'redirect_url' => 'http://localhost/writerwork/payment/flutter/success.php',
            'customer' => [
                'email' => $paymentInfo['customer_email'],
                
            ],
            'meta' => [
                'price' => $paymentInfo['amount']
            ],
            'customizations' => [
                'title' => 'Paying for orderId '.$orderId.'',
                'description' => 'Purchasing this product: '.$title.''
            ]
        ];
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.flutterwave.com/v3/payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($request),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer FLWSECK_TEST-acfc064981812987e2989aade414859b-X',
                'Content-Type: application/json'
            ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
    
        $res = json_decode($response);
        if ($res->status == 'success') {
            // Update database with payment information
            $insertPaymentQuery = "INSERT INTO payment (order_id, tx_ref, amount, currency, payment_options, customer_email) 
                                   VALUES ('$orderId','{$paymentInfo['tx_ref']}', '{$paymentInfo['amount']}', '{$paymentInfo['currency']}', 
                                           '{$paymentInfo['payment_options']}', '{$paymentInfo['customer_email']}')";
    
            mysqli_query($conn, $insertPaymentQuery);
    
            // Redirect to the payment link
            $link = $res->data->link;
            header('Location: ' . $link);
        } else {
            // Handle payment failure
            echo 'Payment failed. Status: ' . $res->status;
        }  
    }
    ?>
</body>

</html>
