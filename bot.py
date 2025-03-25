import telebot

TOKEN = "TELEGRAM_BOT_TOKEN"
bot = telebot.TeleBot(TOKEN)

@bot.message_handler(content_types=["contact"])
def contact_handler(message):
    phone_number = message.contact.phone_number
    bot.reply_to(message, f"เบอร์โทรของคุณคือ: {phone_number}")

bot.polling()