<?php
/**
 * Tests for TellMessage
 */

namespace AsciiSoup\Spires\TellX\Tests;


use AsciiSoup\Spires\TellX\TellMessage;
use Spires\Irc\Message\Inbound\RawMessage;
use Spires\Irc\Parser;
use Spires\Tests\Resources\SpiresTestCase;

class TellMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $text
     * @return RawMessage
     */
    protected function newRawMessage($text)
    {
        $parser = new Parser();
        return RawMessage::fromArray(
            $parser->parse(":FooManChew!~foomanchew@unaffiliated/foomanchew PRIVMSG #phpoxford :{$text}\r\n")
        );
    }

    /**
     * @test
     */
    function it_returns_the_who()
    {
        $message = TellMessage::from($this->newRawMessage("!tell ascii-soup hello there buddy"));
        assertThat($message->who(), is("ascii-soup"));
    }

    /**
     * @test
     */
    function it_returns_the_what()
    {
        $message = TellMessage::from($this->newRawMessage("!tell ascii-soup hello there buddy"));
        assertThat($message->what(), is("hello there buddy"));
    }
}
