<?php
namespace App\NotificationService;

class PusherService implements Service
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
	public function send($data): string {

        // Send Notification using Pusher with pusher configuration
        return "Notification Sent";
	}
}
