<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .success-container {
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .success-icon {
            color: #28a745;
            font-size: 60px;
            animation: scaleCheck 0.6s ease-in-out infinite;
        }

        .success-message {
            margin-top: 20px;
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
        }

        @keyframes scaleCheck {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }
    </style>
</head>
<body>

<div class="success-container">
    <i class="fas fa-check-circle success-icon"></i>
    <div class="success-message">Payment Successful!</div>
    <a href="../../user/userpage2.php">Go back to dashboard</a>
</div>


</body>
</html>
