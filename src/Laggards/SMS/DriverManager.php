<?php namespace Laggards\SMS;

/**
 * Simple-SMS
 * Simple-SMS is a package made for Laravel to send/receive (polling/pushing) text messages.
 *
 * @link http://www.simplesoftware.io
 * @author Maksim (Ellrion) Platonov <ellrion@yandex.ru>, <ellrion11@gmail.com>
 *
 */

use GuzzleHttp\Client;
use Illuminate\Support\Manager;
use Laggards\SMS\Drivers\CallFireSMS;
use Laggards\SMS\Drivers\EmailSMS;
use Laggards\SMS\Drivers\EZTextingSMS;
use Laggards\SMS\Drivers\LabsMobileSMS;
use Laggards\SMS\Drivers\MozeoSMS;
use Laggards\SMS\Drivers\NexmoSMS;
use Laggards\SMS\Drivers\TwilioSMS;
use Laggards\SMS\Drivers\DxwSMS;

class DriverManager extends Manager
{
    /**
     * Get the default sms driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['sms.driver'];
    }

    /**
     * Set the default sms driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['sms.driver'] = $name;
    }

    /**
     * Create an instance of the callfire driver
     *
     * @return CallFireSMS
     */
    protected function createCallfireDriver()
    {
        $config = $this->app['config']->get('sms.callfire', []);

        $provider = new CallFireSMS(new Client);

        $provider->setUser($config['app_login']);
        $provider->setPassword($config['app_password']);

        return $provider;
    }

    /**
     * Creates an instance of the email driver
     *
     * @return EmailSMS
     */
    protected function createEmailDriver()
    {
        $provider = new EmailSMS($this->app['mailer']);

        return $provider;
    }

    /**
     * Create an instance of the eztexting driver
     *
     * @return EZTextingSMS
     */
    protected function createEztextingDriver()
    {
        $config = $this->app['config']->get('sms.eztexting', []);

        $provider = new EZTextingSMS(new Client);

        $data = [
            'User' => $config['username'],
            'Password' => $config['password']
        ];
        $provider->buildBody($data);

        return $provider;
    }

    protected function createLabsMobileDriver()
    {
        $config = $this->app['config']->get('sms.labsmobile', []);

        $provider = new LabsMobileSMS(new Client);

        $auth = [
            'client' => $config['client'],
            'username' => $config['username'],
            'password' => $config['password'],
            'test' => $config['test']
        ];

        $provider->buildBody($auth);

        return $provider;
    }

    /**
     * Create an instance of the mozeo driver
     *
     * @return MozeoSMS
     */
    protected function createMozeoDriver()
    {
        $config = $this->app['config']->get('sms.mozeo', []);

        $provider = new MozeoSMS(new Client);

        $auth = [
            'companykey' => $config['company_key'],
            'username' => $config['username'],
            'password' => $config['password'],
        ];
        $provider->buildBody($auth);

        return $provider;
    }

    /**
     * Create an instance of the nexmo driver
     *
     * @return MozeoSMS
     */
    protected function createNexmoDriver()
    {
        $config = $this->app['config']->get('sms.nexmo', []);

        $provider = new NexmoSMS(
            new Client,
            $config['api_key'],
            $config['api_secret']
        );

        return $provider;
    }

    /**
     * Create an instance of the Twillo driver
     *
     * @return TwilioSMS
     */
    protected function createTwilioDriver()
    {
        $config = $this->app['config']->get('sms.twilio', []);

        return new TwilioSMS(
            new \Services_Twilio($config['account_sid'], $config['auth_token']),
            $config['auth_token'],
            $this->app['request']->url(),
            $config['verify']
        );
    }
	/**
     * Create an instance of the callfire driver
     *
     * @return DxwSMS
     */
    protected function createDxwDriver()
    {
        $config = $this->app['config']->get('sms.dxwang', []);

        $provider = new DxwSMS(new Client);

        $auth = [
            'name' => $config['name'],
            'pwd' => $config['pwd'],
            'sign' => $config['sign'],
        ];
        $provider->buildBody($auth);

        return $provider;
    }
}
