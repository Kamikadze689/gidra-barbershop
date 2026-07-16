<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Отклик на вакансию</title>
</head>
<body style="font-family: Arial, sans-serif; background:#0a0a0a; color:#fff; padding:20px;">

    <h2>Новый отклик на вакансию</h2>

    <p><strong>Вакансия ID:</strong> {{ $data['vacancy_id'] }}</p>
    <p><strong>Имя:</strong> {{ $data['name'] }}</p>
    <p><strong>Телефон:</strong> {{ $data['phone'] }}</p>

</body>
</html>