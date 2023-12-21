<?php
include "../include/connections.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
$title = $_POST['title'];
$description = $_POST['desc'];
$submissionDate = $_POST['subdate'];
$subject = $_POST['subject'];
$orderType = $_POST['ordertype'];
$submissionTime = $_POST['subtime'];
$price = $_POST['price'];
$orderId = "ORDER".uniqid();
// Insert order details
$stmt = $conn->prepare("INSERT INTO orders (orderId, email, title, description, subject, subdate, type, subtime, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $orderId, $email,$title, $description, $subject, $submissionDate,  $orderType, $submissionTime, $price);
$stmt->execute();
$order_id = $stmt->insert_id;
if (!empty($_FILES['files']['name'][0])) {
    $fileDir = "uploads/";
    if (!file_exists($fileDir)) {
        mkdir($fileDir, 0777, true);
    }

    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['files']['name'][$key];
        $file_size = $_FILES['files']['size'][$key];
        $file_type = $_FILES['files']['type'][$key];
        $file_tmp = $_FILES['files']['tmp_name'][$key];

        // Check file size (10MB limit)
        $max_file_size = 10 * 1024 * 1024; // 10MB
        if ($file_size > $max_file_size) {
            echo "File size exceeds the limit (10MB)!";
            continue; // Skip this file
        }

        // Check if the file is a valid type
        $allowed_types = array(
            "application/pdf",
            "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "application/vnd.ms-excel",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.ms-powerpoint",
            "application/vnd.openxmlformats-officedocument.presentationml.presentation",
            "image/jpeg",
            "image/png",
            "image/gif"
        );

        if (in_array($file_type, $allowed_types)) {
            $new_file_name = $fileDir . uniqid() . "_" . $file_name;
            move_uploaded_file($file_tmp, $new_file_name);

            // Insert file details into orderfiles table
            $stmt = $conn->prepare("INSERT INTO orderfiles (orderId, file_path, file_size, file_type) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss",$orderId, $new_file_name, $file_size, $file_type);
            $stmt->execute();
        } else {
            echo "Invalid file type!";
        }
    }
}

$conn->close();
echo "Order submitted successfully!";

}else{
    echo $_SERVER["REQUEST_METHOD"];
}