<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Оставьте отзыв</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h1>Спасибо за визит в GIDRA!</h1>
    
    <p>Уважаемый(ая) {{ $booking->customer_name }},</p>
    
    <p>Благодарим вас за посещение нашего барбершопа. Нам очень важно ваше мнение!</p>
    
    <p>Пожалуйста, оцените качество обслуживания и оставьте отзыв:</p>
    
    <a href="{{ route('review.form', $token) }}" 
       style="display: inline-block; background-color: #000; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 8px; margin: 20px 0;">
        Оставить отзыв
    </a>
    
    <p>С уважением,<br>Команда GIDRA BARBERSHOP</p>
</body>
</html>