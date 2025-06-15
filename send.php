<?php
// Настройки Telegram
$telegram_token = '7996172679:AAFsQ5Or_9X5vMuy8uWiL26RHYie1GPQMfU';
$telegram_chat_id = '418195530';

// Получаем данные из формы
$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';

if (!empty($name) && !empty($phone)) {
    $message = "📝 Новая заявка с сайта:\n\n👤 Имя: $name\n📞 Телефон: $phone";

    $url = "https://api.telegram.org/bot$telegram_token/sendMessage";

    $response = file_get_contents($url . '?' . http_build_query([
        'chat_id' => $telegram_chat_id,
        'text' => $message,
        'parse_mode' => 'HTML',
    ]));

    if ($response) {
        echo "Заявка отправлена успешно!";
    } else {
        echo "Ошибка при отправке.";
    }
} else {
    echo "Пожалуйста, заполните все поля.";
}
?>


// --- Отправка в Google Таблицу ---
$google_url = "https://script.google.com/macros/s/AKfycbTestWebhookForBrika/exec";
$data = http_build_query([
    'name' => $name,
    'phone' => $phone
]);
$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-type: application/x-www-form-urlencoded",
        'content' => $data
    ]
];
$context  = stream_context_create($options);
file_get_contents($google_url, false, $context);