<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Completed</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #ffffff;
            width: 100%;
            max-width: 650px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        .header {
            background: linear-gradient(90deg, #4CAF50, #66bb6a);
            color: #ffffff;
            padding: 25px;
            text-align: center;
        }
        .header img {
            width: 60px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
        }
        .content {
            padding: 30px;
            background-color: #f9f9f9;
            text-align: center;
        }
        .content p {
            font-size: 18px;
            color: #333333;
            margin-bottom: 15px;
        }
        .content .approved-date {
            font-size: 16px;
            color: #777;
            margin-top: 10px;
        }
        .footer {
            padding: 20px;
            background-color: #f1f1f1;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
        .button {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <img src="{{ asset('images/City Health Office Logo.png') }}" alt="CHO Logo">
            <h1>Account Registration Completed</h1>
        </div>

        <!-- Content Section -->
        <div class="content">
            <p>Dear {{ $user->name }},</p>

            <p>An account has been created for you on our system.  Please use the following credentials to log in:</p>

            <p><strong>Email:</strong> {{ $user->email }}<br>
            <strong>Password:</strong> {{ $password }}</p>

            <p><strong>Important:</strong> You will be required to change your password upon your first login.</p>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <p>SafeTagum:Notifiable Disease Information System</p>
        </div>
    </div>
</body>
</html>