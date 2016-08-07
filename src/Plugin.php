<?php
declare(strict_types=1);

namespace AsciiSoup\Spires\TellX;

use Spires\Plugins\BangMessage\Inbound\BangMessage;
use Spires\Plugins\ChannelOperations\Inbound\JoinSystemMessage;

class Plugin
{
    /**
     * @var PDO
     */
    private $database;

    function __construct(PDO $database)
    {
        $this->database = $database;
    }

    public function createTell(BangMessage $message)
    {
        if ($message->bangCommand() === "tell") {
            return TellMessage::from($message);
        }

        return null;
    }

    public function saveTell(TellMessage $message)
    {
        $this->database->prepare("
            INSERT INTO tells VALUES (
                ?, ?, ?, DATETIME('now'), 0
            )
        ")->execute([$message->nickname(), $message->who(), $message->what()]);

        reply("Will do.");
    }

    public function sendTell(JoinSystemMessage $message)
    {
        $statement = $this->database->prepare("
            SELECT author, who, what, \"when\"
            FROM tells
            WHERE who = ?
            AND done = 0
        ");
        $statement->execute([$message->nickname()]);

        foreach ($statement->fetchAll() as $tell) {
            send_to([$tell['who']], $tell['author'] . ' asked me to tell you the following on ' . $tell['when']);
            send_to([$tell['who']], $tell['what']);
            $this->database->prepare("
                UPDATE tells
                SET done = 1
                WHERE author = ?
                AND who = ?
                AND what = ?
                AND \"when\" = ?
            ")->execute([
                $tell['author'],
                $tell['who'],
                $tell['what'],
                $tell['when']
            ]);
        }
    }
}
