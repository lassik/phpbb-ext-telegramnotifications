<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017 Lassi Kortela
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace lassik\telegramnotifications\acp;

class main_module
{
    var $u_action;

    function main($id, $mode)
    {
        global $config, $request, $template, $user;

		$user->add_lang('acp/common');
        $this->tpl_name = 'telegramnotifications_body';
        $this->page_title = $user->lang('ACP_TELEGRAM_NOTIFICATIONS');
        add_form_key('lassik/telegramnotifications');

        if ($request->is_set_post('submit'))
        {
            if (!check_form_key('lassik/telegramnotifications'))
            {
                trigger_error('FORM_INVALID');
            }

            $config->set('lassik_telegram_bot_auth_token',
                         $request->variable('lassik_telegram_bot_auth_token',
                                            ''));

            $config->set('lassik_telegram_chat_id',
                         $request->variable('lassik_telegram_chat_id',
                                            ''));

            trigger_error($user->lang('ACP_TELEGRAM_IDS_UPDATED') .
                          adm_back_link($this->u_action));
        }

        $template->assign_vars(array(
            'U_ACTION' =>
            $this->u_action,

            'LASSIK_TELEGRAM_BOT_AUTH_TOKEN' =>
            $config['lassik_telegram_bot_auth_token'],

            'LASSIK_TELEGRAM_CHAT_ID' =>
            $config['lassik_telegram_chat_id'],
        ));
    }
}
