<?php
/**
 * Encapsulates a '!tell' commmand
 */

namespace AsciiSoup\Spires\TellX;


use Spires\Plugins\BangMessage\Inbound\BangMessage;

class TellMessage extends BangMessage
{
    /**
     * @var string
     */
    private $who;

    /**
     * @var string
     */
    private $what;

    public function __construct($nickname, $username, $hostname, $serverName, $command, $params)
    {
        parent::__construct($nickname, $username, $hostname, $serverName, $command, $params);
        $this->parse();
    }

    private function parse()
    {
        $who = null;
        $what = null;

        $text = $this->text();

        $start = strpos($text, ' ') + 1;
        while (is_null($who) || is_null($what)) {
            $nextSpace = strpos($text, ' ', $start);
            $chunk = substr($text, $start, $nextSpace - $start);
            if (is_null($who)) {
                $who = $chunk;
            } else if (is_null($what)) {
                $what = substr($text, $start);
            }
            $start = $nextSpace + 1;
        }

        $this->who = $who;
        $this->what = $what;
    }

    /**
     * Who to send the message to
     *
     * @return string
     */
    public function who()
    {
        return $this->who;
    }

    /**
     * The message to send
     *
     * @return string
     */
    public function what()
    {
        return $this->what;
    }
}
