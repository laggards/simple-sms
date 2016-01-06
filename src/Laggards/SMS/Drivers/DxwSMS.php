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
use GuzzleHttp\Client;

class DxwSMS extends AbstractSMS implements DriverInterface
{
    /**
     * The Guzzle HTTP Client
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * The API's URL.
     *
     * @var string
     */
    protected $apiBase = 'http://web.duanxinwang.cc/asmx/smsservice.aspx?';

    /**
     * Constructs the MozeoSMS Instance.
     *
     * @param Client $client The guzzle client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Sends a SMS message.
     *
     * @param \Laggards\SMS\OutgoingMessage $message
     * @return void
     */
    public function send(OutgoingMessage $message)
    {
        $composeMessage = $message->composeMessage();

        foreach ($message->getTo() as $to) {
            $data = [
                'mobile' => $to,
                'content' => $composeMessage,
				'stime'=>'',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
				'type'=>'pt',	//必填参数。固定值 pt
				'extno'=>'' 	//可选参数，扩展码，用户定义扩展码，只能为数字
            ];

            $this->buildBody($data);

            $this->postRequest();
        }
    }

    /**
     * Creates many IncomingMessage objects and sets all of the properties.
     *
     * @throws \RuntimeException
     */
    protected function processReceive($rawMessage)
    {
        throw new \RuntimeException('Mozeo does not support Inbound API Calls.');
    }

    /**
     * Checks the server for messages and returns their results.
     *
     * @param array $options
     * @return array
     * @throws \RuntimeException
     */
    public function checkMessages(array $options = [])
    {
        throw new \RuntimeException('Mozeo does not support Inbound API Calls.');
    }

    /**
     * Gets a single message by it's ID.
     *
     * @param string|int $messageId
     * @return \Laggards\SMS\IncomingMessage
     * @throws \RangeException
     */
    public function getMessage($messageId)
    {
        throw new \RuntimeException('Mozeo does not support Inbound API Calls.');
    }

    /**
     * Receives an incoming message via REST call.
     *
     * @param mixed $raw
     * @return \Laggards\SMS\IncomingMessage
     * @throws \RuntimeException
     */
    public function receive($raw)
    {
        throw new \RuntimeException('Mozeo does not support Inbound API Calls.');
    }
}
