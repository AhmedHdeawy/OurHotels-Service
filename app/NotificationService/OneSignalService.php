<?php
namespace App\NotificationService;

class OneSignalService implements Service
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

	/**
	 *
	 * @param  $data
	 *
	 * @return void
	 */
	public function send($data): void {

        // Send Notification using Pusher with pusher configuration
	}
}
