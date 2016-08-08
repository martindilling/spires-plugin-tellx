<?php
/**
 * Encapsulates a '!tell' commmand
 */

namespace AsciiSoup\Spires\TellX;


use Spires\Plugins\BangMessage\Inbound\BangMessage;

class TellMessage extends BangMessage
{
    /**
     * Who to send the message to
     * !tell <who> Hey you
     *
     * @return string
     */
    public function who()
    {
        list($bang, $who, $what) = explode(' ', $this->text(), 3);

        return $who;
    }

    /**
     * The message to send
     * !tell ascii-soup <what>
     *
     * @return string
     */
    public function what()
    {
        list($bang, $who, $what) = explode(' ', $this->text(), 3);

        return $what;
    }
}
