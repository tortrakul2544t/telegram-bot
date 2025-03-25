<?php
// ดึงข้อมูล JSON ที่ Telegram ส่งมา
$content = file_get_contents("php://input");
$update = json_decode($content, true);

// ตรวจสอบว่ามีข้อมูลที่ต้องการไหม
if (isset($update["message"])) {
    $message = $update["message"];
    $chat_id = $message["chat"]["id"];
    $token = "7765519272:AAF5zxUVZVkbxzr3AUZ0QLAXdA4nZzcZJ6s"; // ใส่ Token ตรงนี้

    // ถ้าผู้ใช้ส่งคำสั่ง /start
    if (isset($message["text"]) && $message["text"] === "/start") {
        $welcome_text = "👋 สวัสดี! ส่งเบอร์โทรมาเพื่อรับข้อมูลได้นะ!";
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($welcome_text));
    }

    // ถ้าผู้ใช้แชร์เบอร์โทร
    if (isset($message["contact"])) {
        $phone_number = $message["contact"]["phone_number"];
        $reply = "📞 เบอร์โทรของคุณคือ: $phone_number";
        
        // ส่งข้อความกลับไปที่ผู้ใช้
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($reply));
    }
}

http_response_code(200); // บอก Telegram ว่าได้รับข้อมูลแล้ว
?>