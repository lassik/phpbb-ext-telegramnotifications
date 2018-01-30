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

    $ cd path/to/your/phpBB
    $ git clone https://github.com/lassik/phpbb-ext-telegramnotifications.git ext/lassik/telegramnotifications

In phpBB, go to "ACP" > "Customise" > "Extensions" and enable the
"Telegram Notifications" extension.

Then to "ACP" > "Extensions" > "Telegram Settings" and fill in the
settings. You get the auth token when you make the bot. To get the
chat ID, try the "Find chat ID" page or from the sidebar or see
<https://stackoverflow.com/questions/32423837/telegram-bot-how-to-get-a-group-chat-id>.

Now try to make new posts and see if you get notified on Telegram!

## License

[GPLv2](license.txt)
