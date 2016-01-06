<?php namespace Laggards\SMS\Drivers;

/**
 * Simple-SMS
 * Simple-SMS is a package made for Laravel to send/receive (polling/pushing) text messages.
 *
 * @link http://www.simplesoftware.io
 * @author SimpleSoftware support@simplesoftware.io
 *
 */

use Laggards\SMS\IncomingMessage;
use Laggards\SMS\OutgoingMessage;

interface DriverInterface
{
    /**
     * Sends a SMS message.
     *
     * @param \Laggards\SMS\OutgoingMessage $message
     * @return void
     */
    public function send(OutgoingMessage $message);

    /**
     * Checks the server for messages and returns their results.
     *
     * @param array $options
     * @return array
     */
    public function checkMessages(array $options = []);

    /**
     * Gets a single message by it's ID.
     *
     * @param string|int $messageId
     * @return \Laggards\SMS\IncomingMessage
     */
    public function getMessage($messageId);

    /**
     * Receives an incoming message via REST call.
     *
     * @param mixed $raw
     * @return \Laggards\SMS\IncomingMessage
     */
    public function receive($raw);
}
