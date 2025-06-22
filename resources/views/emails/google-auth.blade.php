<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .credentials {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 1px solid #e0e0e0;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3a3a3a;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
            font-size: 16px;
            border: 2px solid #3a3a3a;
            text-align: center;
            min-width: 200px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #2c2c2c;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Успешная авторизация через Google</h2>
        </div>

        <p>Здравствуйте, {{ $name }}!</p>
        
        <p>Вы успешно авторизовались на сайте DigitalZone через Google.</p>

        <div class="credentials">
            <p><strong>Ваши данные для входа:</strong></p>
            <p>Логин: {{ $login }}</p>
            <p>Пароль: {{ $password }}</p>
        </div>

        <p>Для вашей безопасности рекомендуем сменить пароль:</p>
        
        <center>
            <a href="http://127.0.0.1:8000/change-password" class="button">Сменить пароль</a>
        </center>

        <div class="footer">
            <p>Это автоматическое сообщение, пожалуйста, не отвечайте на него.</p>
            <p>С уважением, команда DigitalZone</p>
        </div>
    </div>
</body>
</html> 