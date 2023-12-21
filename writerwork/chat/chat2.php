<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chat App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #chat-container {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 400px;
            height: 500px;
            background-color: #fff;
            display: flex;
            flex-direction: column;
        }

        #chat-header {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background-color: #25d366;
            color: #fff;
            border-bottom: 1px solid #ccc;
        }

        #chat-header i {
            margin-right: 10px;
        }

        #chat-messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px;
        }

        .message {
            margin-bottom: 10px;
            max-width: 70%;
            word-wrap: break-word;
            position: relative;
            padding: 15px;
            border-radius: 20px;
            font-size: 14px;
            background: linear-gradient(145deg, #e0f7fa, #b2ebf2);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .customer {
            align-self: flex-start;
        }

        .freelancer {
            align-self: flex-end;
            color: #fff;
            background: linear-gradient(145deg, #4caf50, #388e3c);
        }

        .timestamp {
            font-size: 11px;
            color: #888;
            position: absolute;
            bottom: 5px;
            right: 10px;
        }

        #input-container {
            display: flex;
            align-items: center;
            padding: 10px;
            border-top: 1px solid #ccc;
        }

        #message-input {
            flex-grow: 1;
            padding: 8px;
            border: none;
            border-radius: 25px;
            margin-right: 10px;
            font-size: 14px;
        }

        #send-btn, #file-btn {
            background-color: #25d366;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            outline: none;
        }

        #file-input {
            display: none;
        }

        #file-btn {
            background-color: #25d366;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            outline: none;
            display: flex;
            align-items: center;
        }

        #file-btn i {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<div id="chat-container">
    <div id="chat-header">
        <div>
            <i class="fas fa-paperclip"></i>
        </div>
        <div>Chat Title</div>
        <div></div>
    </div>
    <div id="chat-messages">
        <div class="message customer">
            <p>Hello! I'm interested in your services.</p>
            <span class="timestamp">10:30 AM</span>
        </div>
        <div class="message freelancer">
            <p>Hi there! I'd be happy to help. What specific services are you looking for?</p>
            <span class="timestamp">10:35 AM</span>
        </div>
        <!-- Add more messages as needed -->
    </div>
    <div id="input-container">
        <input type="text" id="message-input" placeholder="Type your message...">
        <button id="send-btn" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
        <label id="file-btn" for="file-input">
            <i class="fas fa-paperclip"></i>
        </label>
        <input type="file" id="file-input" accept="image/*,video/*,.doc,.docx,.xls,.xlsx,.pdf" onchange="handleFileSelect()">
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // main.js

    function sendMessage() {
        const messageInput = $("#message-input");
        const fileInput = $("#file-input");

        const message = messageInput.val().trim();
        const files = fileInput[0].files;

        if (message || (files.length > 0)) {
            if (message) {
                appendMessage("User", message, "customer");
                messageInput.val(""); // Clear the input field
            }

            if (files.length > 0) {
                const file = files[0];
                const sender = "User"; // Set the sender (you may dynamically set this based on user authentication)

                // Call your backend function to handle the file
                // sendFile(file, sender);

                // For demonstration purposes, append a message with the file name
                const fileName = file.name;
                appendMessage(sender, fileName, "customer");
            }

            // Call your backend function to handle the message
            $.ajax({
                type: "POST",
                url: "backend.php",
                data: { message: message, sender: "User" },
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.error("Error sending message:", error);
                }
            });
        }
    }

    function handleFileSelect() {
    const fileInput = document.getElementById("file-input");
    const files = fileInput.files;

    if (files.length > 0) {
        const file = files[0];
        const sender = "User"; // Set the sender (you may dynamically set this based on user authentication)

        // Call your backend function to handle the file
        // sendFile(file, sender);

        // For demonstration purposes, append a message with the file name
        const fileName = file.name;
        appendMessage(sender, fileName, "customer");
    }
}


    // Existing functions remain unchanged
</script>
</body>
</html>
