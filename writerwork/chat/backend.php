<?php
include "../include/connections.php";

if (isset($_POST['message'])) {
    $message = $_POST['message'];
    $sender = $_POST['sender'];

    // Handle the text message (you may store it in a database or perform other actions)
    // For demonstration purposes, we'll just echo the message
    echo "Text Message from $sender: $message";
} elseif (isset($_POST['file'])) {
    $fileData = $_POST['file'];
    $sender = $_POST['sender'];

    // Handle the file data (you may save it to a directory or perform other actions)
    // For demonstration purposes, we'll just echo the file name
    echo "File uploaded by $sender: " . getFileNameFromData($fileData);
}

// Function to get the file name from base64-encoded data
function getFileNameFromData($fileData) {
    $dataParts = explode(',', $fileData);
    $encodedData = $dataParts[1];
    $decodedData = base64_decode($encodedData);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->buffer($decodedData);

    // Extract the file extension from the MIME type
    $extension = mimeToExtension($mime);

    // Generate a unique file name
    $fileName = uniqid('file_') . '.' . $extension;

    return $fileName;
}

// Function to convert MIME type to file extension
function mimeToExtension($mime) {
    $mimeMap = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'video/mp4' => 'mp4',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/vnd.ms-excel' => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
        'application/pdf' => 'pdf',
    ];

    return $mimeMap[$mime] ?? null;
}
?>
