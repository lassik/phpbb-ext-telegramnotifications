<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017 Lassi Kortela
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace lassik\telegramnotifications\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration
{
    public function effectively_installed()
    {
        return (isset($this->config['lassik_telegram_bot_auth_token']) &&
                isset($this->config['lassik_telegram_chat_id']));
    }

    static public function depends_on()
    {
        return array('\phpbb\db\migration\data\v320\v320');
    }

    public function update_data()
    {
        return array(
            array('config.add', array('lassik_telegram_bot_auth_token', '')),
            array('config.add', array('lassik_telegram_chat_id', '')),

            array('module.add', array(
                'acp',
                'ACP_CAT_DOT_MODS',
                'ACP_TELEGRAM_NOTIFICATIONS'
            )),
            array('module.add', array(
                'acp',
                'ACP_TELEGRAM_NOTIFICATIONS',
                array(
                    'module_basename' => '\lassik\telegramnotifications\acp\main_module',
                    'modes' => array('settings'),
                ),
            )),
        );
    }
}
