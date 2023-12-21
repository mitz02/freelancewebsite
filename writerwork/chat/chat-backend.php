<?php
$host = "localhost";
$username = "your_username";
$password = "your_password";
$database = "chat_app";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["message"])) {
        $message = $conn->real_escape_string($_POST["message"]);
        $sender = $conn->real_escape_string($_POST["sender"]);

        $sql = "INSERT INTO messages (content, sender) VALUES ('$message', '$sender')";

        if ($conn->query($sql) === TRUE) {
            echo "Message sent successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST["file"])) {
        $fileData = $conn->real_escape_string($_POST["file"]);
        $sender = $conn->real_escape_string($_POST["sender"]);

        // Process and store the file as needed
        // For simplicity, you can store the file content in the database (not recommended for large files)
        // In a real-world scenario, consider storing files on the server or using cloud storage services
        $sql = "INSERT INTO messages (content, sender) VALUES ('$fileData', '$sender')";

        if ($conn->query($sql) === TRUE) {
            echo "File uploaded successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST["audio"])) {
        $audioData = $conn->real_escape_string($_POST["audio"]);
        $sender = $conn->real_escape_string($_POST["sender"]);
        $recordingTime = $conn->real_escape_string($_POST["recordingTime"]);

        // Process and store the audio recording as needed
        // For simplicity, you can store the audio content in the database (not recommended for large audio files)
        // In a real-world scenario, consider storing audio files on the server or using cloud storage services
        $sql = "INSERT INTO messages (content, sender, recording_time) VALUES ('$audioData', '$sender', '$recordingTime')";

        if ($conn->query($sql) === TRUE) {
            echo "Audio recording sent successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sql = "SELECT * FROM messages ORDER BY timestamp DESC LIMIT 10";
    $result = $conn->query($sql);

    $messages = array();
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode($messages);
}

$conn->close();
?>
