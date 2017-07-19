<?php
/**
 *
 * @package phpBB Extension - Acme Demo
 * @copyright (c) 2013 phpBB Group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace acme\demo\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class main_listener implements EventSubscriberInterface
{
    static public function getSubscribedEvents()
    {
        return array(
            'core.submit_post_end' => 'handle_submit_post_end',
        );
    }

    /* @var \phpbb\controller\helper */
    protected $helper;

    /* @var \phpbb\template\template */
    protected $template;

    /**
     * Constructor
     *
     * @param \phpbb\controller\helper   $helper     Controller helper object
     * @param \phpbb\template\template   $template   Template object
     */
    public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template)
    {
        $this->helper = $helper;
        $this->template = $template;
    }

    /**
     * @param Event $event
     */
    public function handle_submit_post_end($event)
    {
        $mode = $event['mode'];
        if ($mode === 'edit')
            return;
        $user = $event['username'];
        $prefix = $this->prefix_from_mode($mode);
        $title = html_entity_decode($event['data']['topic_title']);
        $url = generate_board_url().'/'.
             preg_replace('/^.\//', '', html_entity_decode($event['url']));
        $message = '['.$user.'] '.$prefix.$title.'. '.$url;
        $this->send_message_as_telegram_bot($message);
    }

    private function prefix_from_mode($mode) {
        if ($mode === 'post') {
            return '';
        } else if ($mode === 'reply') {
            return 'Re: ';
        } else {
            return ucfirst($mode).': ';
        }
    }

    private function send_message_as_telegram_bot($text) {
        $bot = 'bot'.$this->TELEGRAM_BOT_AUTH_TOKEN;
        $url = 'https://api.telegram.org/'.urlencode($bot).'/sendMessage';
        $data = array('chat_id' => $this->TELEGRAM_BOT_CHAT_ID, 'text' => $text);
        $curl = curl_init($url);
        //curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
        curl_exec($curl);
        curl_close($curl);
    }

    private $TELEGRAM_BOT_AUTH_TOKEN = 'fill_me_in';
    private $TELEGRAM_BOT_CHAT_ID = 'fill_me_in';
}
