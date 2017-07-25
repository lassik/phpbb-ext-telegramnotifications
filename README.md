# phpBB 3.2 Extension - Telegram notifications #

> Things are moving so fast in my head that I'm starting to
edit... like a telegram.

## What is this?

This is a phpBB extension that sends a message to any Telegram chat
(group chat or private chat) via a Telegram bot whenever someone makes
a new topic or replies to an existing topic on the phpBB forum.

## History

The code is based off
of
[phpbb/phpbb-ext-acme-demo](https://github.com/phpbb/phpbb-ext-acme-demo) and
[haivala/phpBB-Entropy-Extension](https://github.com/haivala/phpBB-Entropy-Extension) (a
similar extension for Slack notifications).

## Installation

Make your own Telegram bot.

Clone this Git repository into `phpBB/ext/lassik/telegramnotifications`:

    $ git clone https://github.com/lassik/phpbb-ext-telegramnotifications.git phpBB/ext/lassik/telegramnotifications

Manually fill in the constants at the end of the source file `event/main_listener.php`:

* `$TELEGRAM_BOT_AUTH_TOKEN`
* `$TELEGRAM_BOT_CHAT_ID`

You get the auth token when you make the bot. To get the chat ID,
see
<https://stackoverflow.com/questions/32423837/telegram-bot-how-to-get-a-group-chat-id>.

In phpBB, go to "ACP" > "Customise" > "Extensions" and enable the
"Acme Demo Extension" extension.

Now try to make new posts and see if you get notified on Telegram!

## License

[GPLv2](license.txt)
