<?php
$TOKEN = getenv("TELEGRAM_BOT_TOKEN"); // ใช้ GitHub Secrets
$API_URL = "https://api.telegram.org/bot$TOKEN/";

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}

$chat_id = $update["message"]["chat"]["id"];
$text = $update["message"]["text"];

if ($text == "/start") {
    sendMessage($chat_id, "👋 สวัสดี! กรุณาส่งเบอร์โทรของคุณโดยใช้ปุ่มด้านล่าง");
    sendContactRequest($chat_id);
} elseif (isset($update["message"]["contact"])) {
    $phone_number = $update["message"]["contact"]["phone_number"];
    sendMessage($chat_id, "📞 ขอบคุณ! หมายเลขโทรศัพท์ของคุณคือ: $phone_number");
}

function sendMessage($chat_id, $text) {
    global $API_URL;
    file_get_contents($API_URL . "sendMessage?chat_id=$chat_id&text=" . urlencode($text));
}

function sendContactRequest($chat_id) {
    global $API_URL;
    $keyboard = json_encode([
        "keyboard" => [[["text" => "📲 ส่งเบอร์โทร", "request_contact" => true]]],
        "resize_keyboard" => true,
        "one_time_keyboard" => true
    ]);
    file_get_contents($API_URL . "sendMessage?chat_id=$chat_id&text=" . urlencode("กรุณาส่งเบอร์โทรของคุณ") . "&reply_markup=" . urlencode($keyboard));
}
?>
